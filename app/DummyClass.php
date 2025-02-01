<?php
namespace Newscast\App;

use Newscast\Services\RequestService as Request;

class Dummy {
   public function show(): void {
      echo "hai from dummy";
   }

   public function store( Request $request ): void {
      $my_post_param = $request->abc;

      echo "My post param is: " . $my_post_param;
   }
}