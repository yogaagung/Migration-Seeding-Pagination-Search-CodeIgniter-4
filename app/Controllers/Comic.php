<?php

namespace App\Controllers;

use App\Models\ComicModel;

class Comic extends BaseController
{
    protected $comicModel;
    public function __construct()
    {
        $this->comicModel = new ComicModel();
    }

    public function index()
    {
        //$comic = $this->comicModel->findAll();
        $data = [
            'title' => 'List Comic | My Blog',
            'comic' => $this->comicModel->getComic()
        ];

        //Without Db Connection
        // $db = \Config\Database::connect();
        // $comic = $db->query("SELECT * FROM comic");
        // dd($comic);
        // foreach($comic->getResultArray() as $com){
        //     d($com);
        // }

        return view('comic/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Comic | My Blog',
            'comic' => $this->comicModel->getComic($slug)
        ];
        //if Comic Null
        if (empty($data['comic'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Title' . $slug . 'Not Found');
        }
        return view('comic/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Comic | My Blog',
            'validation' => \Config\Services::validation(),
        ];
        return view('comic/create', $data);
    }

    public function save()
    {
        //Input Validation
        if (!$this->validate([
            'title' => [
                'rules' => 'required|is_unique[comic.title]',
                'errors' => [
                    'requred' => '{field} must be filled.',
                    'is_unique' => '{field} already registered'
                ]
            ],
            'cover' => [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Image Size to Large',
                    'is_image' => 'Not Image',
                    'mime_in' => 'Not Image',
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/comic/create')->withInput()->with('validation', $validation);
            return redirect()->to('/comic/create/' . $this->request->getVar('slug'))->withInput();
        }

        // Get cover
        $fileCover = $this->request->getFile('cover');
        // Cek if not have Cover
        if ($fileCover->getError() == 4) {
            $nameCover = 'default.png';
        } else {
            //Generate Random name cover
            $nameCover = $fileCover->getRandomName();
            // Move to foledr img
            $fileCover->move('img', $nameCover);
        }
        // Get name file cover
        // $nameCover = $fileCover->getName();

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->comicModel->save(
            [
                'title' => $this->request->getVar('title'),
                'slug' => $slug,
                'author' => $this->request->getVar('author'),
                'publisher' => $this->request->getVar('publisher'),
                'cover' => $nameCover,
            ]
        );
        session()->setFlashdata('message', 'Successful Add Comic');
        return redirect()->to('/comic');
    }

    public function delete($id)
    {
        // Search img based id
        $comic = $this->comicModel->find($id);
        //Cek if file cover default
        if ($comic['cover'] != 'default.png') {
            // Delete Cover
            unlink('img/' . $comic['cover']);
        }

        $this->comicModel->delete($id);
        session()->setFlashdata('message', 'Successful Delete Comic');
        return redirect()->to('/comic');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Edit Comic | My Blog',
            'validation' => \Config\Services::validation(),
            'comic' => $this->comicModel->getComic($slug),
        ];
        return view('comic/edit', $data);
    }

    public function update($id)
    {
        //Cek Title
        $comicOld = $this->comicModel->getComic($this->request->getVar('slug'));
        if ($comicOld['title'] == $this->request->getVar('title')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required|is_unique[comic.title]';
        }
        //Input Validation
        if (!$this->validate([
            'title' => [
                'rules' => $rule_title,
                'errors' => [
                    'requred' => '{field} must be filled.',
                    'is_unique' => '{field} already registered'
                ]
            ],
            'cover' => [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Image Size to Large',
                    'is_image' => 'Not Image',
                    'mime_in' => 'Not Image',
                ]
            ]
        ])) {
            return redirect()->to('/comic/edit/' . $this->request->getVar('slug'))->withInput();

            $fileCover = $this->request->getFile('cover');
            // cek img, old img?
            if ($fileCover->getError() == 4) {
                $nameCover = $this->request->getVar('oldCover');
            } else {
                // Generate random name
                $nameCover = $fileCover->getRandomName();
                // Upload Img
                $fileCover->move('img', $nameCover);
                // Delete old Img
                unlink('/img' . $this->request->getVar('oldCover'));
            }

            $slug = url_title($this->request->getVar('title'), '-', true);
            $this->comicModel->save(
                [
                    'id' => $id,
                    'title' => $this->request->getVar('title'),
                    'slug' => $slug,
                    'author' => $this->request->getVar('author'),
                    'publisher' => $this->request->getVar('publisher'),
                    'cover' => $nameCover,
                ]
            );
            session()->setFlashdata('message', 'Successful Add Comic');
            return redirect()->to('/comic');
        }
    }
}
