<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductImagesModel extends Model
{
    protected $table = 'tbl_productimages';
    protected $primaryKey = 'productimages_id';
    protected $allowedFields = ['product_image','product_id','created_at','updated_at','added_by','is_deleted'];
}