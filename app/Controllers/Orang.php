<?php

namespace App\Controllers;

use App\Models\OrangModel;

class Orang extends BaseController
{
    protected $orangModel;
    public function __construct()
    {
        $this->orangModel = new OrangModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $orang = $this->orangModel->search($keyword);
        } else {
            $orang = $this->orangModel;
        }
        //$comic = $this->comicModel->findAll();
        $data = [
            'title' => 'List Orang | My Blog',
            // 'orang' => $this->orangModel->findAll()
            'orang' => $orang->paginate(10, 'orang'),
            'pager' => $this->orangModel->pager,
            'currentPage' => $currentPage,
        ];

        //Without Db Connection
        // $db = \Config\Database::connect();
        // $comic = $db->query("SELECT * FROM comic");
        // dd($comic);
        // foreach($comic->getResultArray() as $com){
        //     d($com);
        // }

        return view('orang/index', $data);
    }
}
