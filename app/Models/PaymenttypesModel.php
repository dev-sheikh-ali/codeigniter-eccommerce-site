<?php
namespace App\Models;

use CodeIgniter\Model;

class PaymenttypesModel extends Model
{
    protected $table = 'tbl_paymenttypes';
    protected $primaryKey = 'paymenttype_id ';
    protected $allowedFields = ['paymenttype_name','description','is_deleted'];
}