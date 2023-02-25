<?php

class Comment
{
   private $db;

   public function __construct()
   {
      $this->db = new Database();
   }

   //Lấy dữ liệu id lớn nhất để tiến hành bước sau là update_view
   public function getComment()
   {
      $query = "SELECT * FROM tbl_comment";
      $result = $this->db->select($query);
      if ($result) {
         $result = General::getArrayFetchAssoc($result);
         $new_arr = [];
         foreach ($result as $value) {
            foreach ($value as $key => $item) {
               if (
                  $key == 'created_by_admin' || $key == 'created_by_current_user'
                  || $key == 'user_has_upvoted' || $key == 'is_new'
               ) {
                  $value[$key] =  $value[$key] != 0 ? true : false;
               } elseif ($key == 'id' || $key == 'upvote_count' || $key == 'creator') {
                  $value[$key] = (int)$value[$key];
               } elseif ($key == 'attachments' || $key == 'pings') {
                  $value[$key] = json_decode($value[$key]);
               }
            }
            array_push($new_arr, $value);
         }
      }
      return $new_arr ?? false;
   }
}
