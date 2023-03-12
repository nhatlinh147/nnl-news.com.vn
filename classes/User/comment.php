<?php

use Google\Service\CloudFunctions\Retry;

Path::path_file_include('Autoload', 'Resize_image');

if (!session_id()) {
   session_start();
}

class Init
{
   public $db, $carbon, $customer_id;
   function __construct()
   {
      $this->db = new Database();
      $this->carbon = new Carbon\Carbon;
      $this->customer_id = $_SESSION['Customer_ID'];
   }

   //Cập nhật lại trạng thái bình chọn
   protected function update_is_new($date_compare, $comment_id, $update)
   {
      if ($update != "false") {
         $now =  $this->carbon->now('Asia/Ho_Chi_Minh');
         $diff = $now->diffInHours($this->carbon->parse($date_compare));
         if ($diff > 24) {
            $query = "UPDATE tbl_comment SET is_new = 0 WHERE id = '$comment_id'";
         } else {
            $query = "UPDATE tbl_comment SET is_new = 1 WHERE id = '$comment_id'";
         }
         $this->db->update($query);
      }
   }

   protected function getChildComment($result)
   {
      $result_child = [];
      foreach ($result as $value) {
         $parent = $value['id'];

         //Lấy những comment child (tức là reply)
         $query = "SELECT * FROM tbl_comment WHERE parent = '$parent'";
         $result_one = $this->db->select($query);
         if ($result_one) {
            $result_one = General::getArrayFetchAssoc($result_one);

            //chuyển dữ liệu comment child vào một array chung
            foreach ($result_one as $item) {
               array_push($result_child, $item);
            }
         }
      }
      return $result_child ?? [];
   }

   //Tải hình ảnh lên
   protected function update_upload_image($get_id)
   {
      $total_attach = empty($_FILES['attachments']['name']) ? 0 : count($_FILES['attachments']['name']);
      $new_arr = [];
      if ($total_attach > 0) {
         for ($index = 0; $index < $total_attach; $index++) {
            /* Getting file name */
            $filename = $_FILES['attachments']['name'][$index];

            /* Location */
            $div = explode('.', $filename);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = BASE_DISK . "/view/upload/comment/" . $unique_image;

            $imageFileType = pathinfo($uploaded_image, PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);

            /* Valid extensions */
            $valid_extensions = array("jpg", "jpeg", "png");

            /* Check file extension */
            if (in_array(strtolower($imageFileType), $valid_extensions)) {
               /* Upload file */
               sleep(1);

               if (move_uploaded_file($_FILES['attachments']['tmp_name'][$index], $uploaded_image)) {
                  //Thay đổi kích thước ảnh
                  $resizeObj = new resize($uploaded_image);
                  $resizeObj->resizeImage(200, 200, 'auto');
                  $resizeObj->saveImage($uploaded_image, 200);
               }
            }
            $attach = [
               'file' => General::view_link("view/upload/comment/" . $unique_image, true),
               'mime_type' => $_FILES['attachments']['type'][$index]
            ];
            array_push($new_arr, $attach);
         }

         for ($index = 0; $index < $total_attach; $index++) {
            $new_arr[$index]['id'] = $get_id;
         }
         $new_arr = json_encode($new_arr);

         $this->db->update("UPDATE tbl_comment SET attachments = '$new_arr' WHERE id = '$get_id'");
      }
   }
   //Cập nhật reply bình luận
   protected function update_parent($get_id, $parent)
   {
      if ($parent) {
         $this->db->update("UPDATE tbl_comment SET parent = '$parent' WHERE id = '$get_id'");
      }
   }

   //Lấy bình luận bằng id
   protected function getCommentById($comment_id)
   {
      $query = "SELECT * FROM tbl_comment WHERE id = '$comment_id'";
      $result = $this->db->select($query);
      return $result ? $result->fetch_assoc() : [];
   }

   //Xóa hình ảnh
   protected function removeImage($result)
   {
      $get_attach = json_decode($result['attachments'], true);

      //Xóa hình ảnh
      $array = array_filter($get_attach, function ($item) {
         $file_image = explode("/", $item['file']);
         $file_image = array_pop($file_image);
         unlink(BASE_DISK . '/view/upload/comment/' . $file_image);
         return $file_image;
      });
   }
}
class Comment extends Init
{
   public function __construct()
   {
      parent::__construct();
   }

   //Lấy dữ liệu id lớn nhất để tiến hành bước sau là update_view
   public function getComment()
   {
      $product_id = $_GET['product_id'];
      $fullname = $_GET['fullname'];
      $record_per_page = $_GET['record_per_page'];

      //truy vấn có giới hạn dữ liệu theo limit
      $query = "SELECT * FROM tbl_comment WHERE Product_ID = '$product_id' AND parent IS NULL
      ORDER BY id DESC LIMIT $record_per_page";
      $result = $this->db->select($query);

      if ($result) {
         $result = General::getArrayFetchAssoc($result);

         //Lấy comment child
         $result_child = $this->getChildComment($result);

         //Kết hợp comment parent và reply
         $result = array_merge($result, $result_child);

         $new_arr = [];

         foreach ($result as $result_value) {
            //Update lại tình trạng bình luận
            $this->update_is_new($result_value['modified'], $result_value['id'], $_GET['update']);

            //đối chiếu với bảng tbl_vote_comment lấy dữ liệu user_has_upvoted
            $query = "SELECT * FROM tbl_vote_comment WHERE Customer_ID = '$this->customer_id' AND Comment_ID = " . $result_value['id'];
            $get_comment = $this->db->select($query);

            if ($get_comment) {
               $get_comment = $get_comment->fetch_assoc();
               $result_value['user_has_upvoted'] = $get_comment['Vote_Status'];
            } else {
               $result_value['user_has_upvoted'] = 0;
            }
            //Đưa dữ liệu tính số comment parent đưa vào mảng
            $count = $this->db->select("SELECT COUNT(*) as comment_count FROM tbl_comment WHERE parent IS NULL");
            $count = $count->fetch_assoc()["comment_count"];
            $result_value['count'] = $count;

            //Định dạng dữ liệu cho phù hợp
            foreach ($result_value as $key => $item) {
               if (
                  $key == 'created_by_admin' || $key == 'created_by_current_user'
                  || $key == 'user_has_upvoted' || $key == 'is_new'
               ) {
                  $result_value[$key] =  $result_value[$key] != 0 ? true : false;
               } elseif ($key == 'id' || $key == 'upvote_count' || $key == 'creator' || $key == 'count') {
                  $result_value[$key] = (int)$result_value[$key];
               } elseif ($key == 'attachments' || $key == 'pings') {
                  $result_value[$key] = json_decode($result_value[$key]);
               } elseif ($result_value[$key] == $fullname) {
                  $result_value['created_by_current_user'] = true;
               }
            }

            array_push($new_arr, $result_value);
         }
      }
      return $new_arr ?? [];
   }

   public function insertComment()
   {
      $carbon = new Carbon\Carbon;
      $date = $carbon->now('Asia/Ho_Chi_Minh');
      $content = $_POST['content'];
      $fullname = $_POST['fullname'];
      $product_id = $_POST['product_id'];
      $parent = $_POST['parent'] ?? false;

      $query = "INSERT INTO tbl_comment(parent,created,modified,content,attachments,pings,fullname,profile_picture_url,created_by_admin,created_by_current_user,upvote_count,is_new,Product_ID)
      VALUES (null,'$date','$date','$content','[]','[]','$fullname','https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',0,0,0,1,'$product_id')";
      $result = $this->db->insert($query);

      $result = $this->db->select("SELECT LAST_INSERT_ID()");
      $result = $result->fetch_assoc();
      $get_id = $result["LAST_INSERT_ID()"];

      //Upload image
      $this->update_upload_image($get_id);

      //Update parent
      $this->update_parent($get_id, $parent);
   }

   public function updateVoted()
   {
      $comment_id = $_GET['comment_id'] ?? false;
      $upvote_count = $_GET['upvote_count'] ?? false;
      $user_has_upvoted = $_GET['user_has_upvoted'] ?? false;

      if ($comment_id) {
         $comment_id = (int)$_GET['comment_id'];
         $query = "UPDATE tbl_comment SET upvote_count = '$upvote_count' WHERE id = '$comment_id'";
         $this->db->update($query);

         // chèn hoặc cập nhật dữ liệu vào tbl_vote_comment
         $query = "SELECT * FROM tbl_vote_comment WHERE Comment_ID = '$comment_id' AND Customer_ID = '$this->customer_id'";
         $get_vote = $this->db->select($query);

         if (!$get_vote) {
            $query =  "INSERT INTO tbl_vote_comment(Comment_ID,Vote_Status,Customer_ID)
            VALUES('$comment_id','$user_has_upvoted','$this->customer_id')";
            $this->db->insert($query);
         } else {
            $query =  "UPDATE tbl_vote_comment SET Vote_Status = '$user_has_upvoted'
            WHERE Comment_ID = '$comment_id' AND Customer_ID = '$this->customer_id'";
            $this->db->update($query);
         }
      }
   }

   public function update_comment()
   {
      $comment_id = $_POST['comment_id'] ?? false;
      $content = $_POST['content'] ?? false;
      $attachments = $_POST['attachments[]'] ?? false;

      if ($comment_id) {
         if ($content) {
            //Update content
            $query = "UPDATE tbl_comment SET content = '$content' WHERE id = '$comment_id'";
            $this->db->update($query);
         }

         $comment_id = (int)$_POST['comment_id'];
         $result = $this->getCommentById($comment_id);

         if ($result && !empty($_FILES['attachments'])) {
            // Xóa ảnh
            $this->removeImage($result);

            // Upload image
            $this->update_upload_image($comment_id);
         }

         //Cập nhật ngày sửa bình luận
         $now =  $this->carbon->now('Asia/Ho_Chi_Minh');
         $query = "UPDATE tbl_comment SET modified = '$now' WHERE id = '$comment_id'";
         $this->db->update($query);
      }
   }

   public function delete_comment()
   {
      $comment_id = $_POST['comment_id'] ?? false;
      if ($comment_id) {
         // xóa ảnh
         $result = $this->getCommentById($comment_id);
         $this->removeImage($result);

         // xóa dữ liệu theo comment_id
         $query = "DELETE FROM tbl_comment where id = '$comment_id'";
         $this->db->delete($query);
      }
   }
}
