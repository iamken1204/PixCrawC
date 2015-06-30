<?php
namespace cronnos;

use helpers\VarDumper;
use helpers\ExceptionHandler as EH;
use helpers\RegValidator;
use helpers\IpProcessor;
use cronnos\App;

class Form
{
    public $db;

    public $tableName = 'find_bear_form';

    public function __construct()
    {
        $this->db = App::$db;
    }

    /**
     * Fetch, validate form data then insert into database
     * @param  array $data form data
     * @return array $res  [
     *                         'code' => integer,
     *                         'message' => string (if something went wrong)
     *                     ]
     */
    public function insert($data)
    {
        try {
            $res = $this->validate($data);
            if ($res['code'] !== 200)
                throw new \Exception($res['message'] . $res['code'], 400);
            $ipDetail = IpProcessor::getIpDetail();
            $now = date("Y-m-d H:i:s");
            $res = $this->db->insert($this->tableName, [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'edm' => $data['emd'],
                'ip' => $ipDetail['ip'],
                'ip_detail' => $ipDetail['detail'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
            if (empty($res))
                throw new \Exception("表格儲存錯誤，請重新填表", 401);
            $res = [
                'code' => 200
            ];
            return $res;
        } catch (\Exception $e) {
            $eh = new EH($e);
            return $eh::returnArray();
        }
    }

    /**
     * validate form columns
     * @param  array $data form data
     * @return array [
     *                   'code' => integer,
     *                   'message' => string(if validation was fail)
     *               ]
     */
    private function validate($data)
    {
        try {
            if (empty($data['name']) ||
                empty($data['phone']) ||
                empty($data['email']))
                throw new \Exception("請輸入所有表格欄位!", 400);
            if ($data['policy'] !== 1)
                throw new \Exception("請確認已閱讀隱私權政策!", 401);
            $rv = new RegValidator;
            if (!$rv->validateEmail($data['email']))
                throw new \Exception("請輸入正確的電子信箱!", 402);
            if (!$rv->ValidatePhone($data['phone']))
                throw new \Exception("請輸入正確的電話號碼!", 403);
            if ($data['edm'] !== 0 && $data['edm'] !== 1)
                throw new \Exception("請確認收取電子報意願!", 404);
            return ['code' => 200];
        } catch (\Exception $e) {
            $eh = new EH($e);
            return $eh::returnArray();
        }
    }

    /**
     * Test if CRUD operates well.
     * if success:
     * @return  array [
     *                    'code' => 200
     *                ]
     * if something went wrong:
     * @return  array [
     *                    'code' => integer,
     *                    'message' => string
     *                ]
     */
    public function testCRUD()
    {
        try {
            $db = $this->db;
            $now = date("Y-m-d H:i:s");
            // create
            $res = $db->insert($this->tableName, [
                'name' => '測試用',
                'phone' => 0988135599,
                'email' => 'iamke@goo.c',
                'edm' => 1,
                'ip' => '255.255.255.255',
                '(JSON)ip_detail' => [
                    'xxx' => 'ffff:ffff:ffff:ffff',
                    'yyy' => 'ffff:ffff:ffff:ffff:ffff:ffff',
                    'zzz' => 'ffff:ffff:ffff:ffff:ffff:ffff'
                ],
                'created_at' => $now,
                'updated_at' => $now
            ]);
            if (empty($res))
                throw new \Exception("database's insertion error!", 400);
            // read
            $res = $db->select($this->tableName, [
                'id',
                'name',
                'email'
            ], [
                "name" => '測試用'
            ]);
            if (empty($res))
                throw new \Exception("database's reading error!", 401);
            // update
            $res = $db->update($this->tableName, [
                'name' => 'JUSTFORTEST'
            ], [
                'name' => '測試用'
            ]);
            if (empty($res))
                throw new \Exception("database's updating error!", 402);
            // delete
            $res = $db->delete($this->tableName, [
                'AND' => [
                    'name' => 'JUSTFORTEST'
                ],
            ]);
            if (empty($res))
                throw new \Exception("database's deleting error!", 403);
            $res = ['code' => 200];
            return $res;
        } catch (\Exception $e) {
            $eh = new EH($e);
            return $eh::returnArray();
        }
    }
}
