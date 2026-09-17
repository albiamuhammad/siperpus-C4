<?php

namespace App\Controllers;

use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Member extends BaseController
{
    /**
     * =========================================================
     * DAFTAR ANGGOTA + SEARCH + PAGINATION
     * =========================================================
     */
    public function index()
    {
        $memberModel = new MemberModel();


        // Ambil keyword pencarian dari URL
        $keyword = trim(
            (string) $this->request->getGet('keyword')
        );


        // Jika ada keyword, lakukan pencarian
        if ($keyword !== '') {

            $memberModel
                ->groupStart()

                ->like(
                    'member_code',
                    $keyword
                )

                ->orLike(
                    'name',
                    $keyword
                )

                ->orLike(
                    'email',
                    $keyword
                )

                ->orLike(
                    'phone',
                    $keyword
                )

                ->orLike(
                    'status',
                    $keyword
                )

                ->groupEnd();
        }


        // Ambil nomor halaman
        $currentPage =
            (int) (
                $this->request->getGet('page')
                ?? 1
            );


        if ($currentPage < 1) {
            $currentPage = 1;
        }


        // Jumlah data per halaman
        $perPage = 5;


        // Ambil data
        $members = $memberModel
            ->orderBy('name', 'ASC')
            ->paginate($perPage);


        // Kirim data ke View
        $data = [
            'title'       => 'Data Anggota',
            'members'     => $members,
            'pager'       => $memberModel->pager,
            'keyword'     => $keyword,
            'currentPage' => $currentPage,
            'perPage'     => $perPage,
        ];


        return view(
            'anggota/index',
            $data
        );
    }


    /**
     * =========================================================
     * FORM TAMBAH ANGGOTA
     * =========================================================
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Anggota',
        ];

        return view(
            'anggota/create',
            $data
        );
    }


    /**
     * =========================================================
     * SIMPAN ANGGOTA BARU
     * =========================================================
     */
    public function store()
    {
        $rules = [

            'member_code' => [
                'rules' =>
                    'required|max_length[20]|is_unique[members.member_code]',

                'errors' => [
                    'required' =>
                        'Kode anggota wajib diisi.',

                    'max_length' =>
                        'Kode anggota maksimal 20 karakter.',

                    'is_unique' =>
                        'Kode anggota sudah digunakan.',
                ],
            ],


            'name' => [
                'rules' =>
                    'required|max_length[150]',

                'errors' => [
                    'required' =>
                        'Nama anggota wajib diisi.',

                    'max_length' =>
                        'Nama anggota maksimal 150 karakter.',
                ],
            ],


            'email' => [
                'rules' =>
                    'required|valid_email|max_length[150]|is_unique[members.email]',

                'errors' => [
                    'required' =>
                        'Email wajib diisi.',

                    'valid_email' =>
                        'Format email tidak valid.',

                    'max_length' =>
                        'Email maksimal 150 karakter.',

                    'is_unique' =>
                        'Email sudah digunakan oleh anggota lain.',
                ],
            ],


            'phone' => [
                'rules' =>
                    'permit_empty|max_length[25]',

                'errors' => [
                    'max_length' =>
                        'Nomor telepon maksimal 25 karakter.',
                ],
            ],


            'address' => [
                'rules' =>
                    'permit_empty|max_length[500]',

                'errors' => [
                    'max_length' =>
                        'Alamat maksimal 500 karakter.',
                ],
            ],


            'status' => [
                'rules' =>
                    'required|in_list[active,inactive]',

                'errors' => [
                    'required' =>
                        'Status anggota wajib dipilih.',

                    'in_list' =>
                        'Status anggota tidak valid.',
                ],
            ],
        ];


        if (! $this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }


        $data = [

            'member_code' => trim(
                (string)
                $this->request->getPost(
                    'member_code'
                )
            ),

            'name' => trim(
                (string)
                $this->request->getPost(
                    'name'
                )
            ),

            'email' => trim(
                (string)
                $this->request->getPost(
                    'email'
                )
            ),

            'phone' => trim(
                (string)
                $this->request->getPost(
                    'phone'
                )
            ) ?: null,

            'address' => trim(
                (string)
                $this->request->getPost(
                    'address'
                )
            ) ?: null,

            'status' =>
                $this->request->getPost(
                    'status'
                ),
        ];


        $memberModel = new MemberModel();

        $memberModel->insert($data);


        return redirect()
            ->to(site_url('anggota'))
            ->with(
                'success',
                'Data anggota berhasil ditambahkan.'
            );
    }


    /**
     * =========================================================
     * DETAIL ANGGOTA
     * =========================================================
     */
    public function show($id)
    {
        $memberModel = new MemberModel();

        $member = $memberModel->find($id);


        if ($member === null) {

            throw PageNotFoundException::forPageNotFound(
                'Data anggota tidak ditemukan.'
            );
        }


        $data = [
            'title'  => 'Detail Anggota',
            'member' => $member,
        ];


        return view(
            'anggota/show',
            $data
        );
    }


    /**
     * =========================================================
     * FORM EDIT ANGGOTA
     * =========================================================
     */
    public function edit($id)
    {
        $memberModel = new MemberModel();

        $member = $memberModel->find($id);


        if ($member === null) {

            throw PageNotFoundException::forPageNotFound(
                'Data anggota tidak ditemukan.'
            );
        }


        $data = [
            'title'  => 'Edit Anggota',
            'member' => $member,
        ];


        return view(
            'anggota/edit',
            $data
        );
    }


    /**
     * =========================================================
     * UPDATE ANGGOTA
     * =========================================================
     */
    public function update($id)
    {
        $memberModel = new MemberModel();

        $member = $memberModel->find($id);


        if ($member === null) {

            throw PageNotFoundException::forPageNotFound(
                'Data anggota tidak ditemukan.'
            );
        }


        $rules = [

            'member_code' => [
                'rules' =>
                    'required|max_length[20]|is_unique[members.member_code,id,'
                    . $id
                    . ']',

                'errors' => [
                    'required' =>
                        'Kode anggota wajib diisi.',

                    'max_length' =>
                        'Kode anggota maksimal 20 karakter.',

                    'is_unique' =>
                        'Kode anggota sudah digunakan.',
                ],
            ],


            'name' => [
                'rules' =>
                    'required|max_length[150]',

                'errors' => [
                    'required' =>
                        'Nama anggota wajib diisi.',

                    'max_length' =>
                        'Nama anggota maksimal 150 karakter.',
                ],
            ],


            'email' => [
                'rules' =>
                    'required|valid_email|max_length[150]|is_unique[members.email,id,'
                    . $id
                    . ']',

                'errors' => [
                    'required' =>
                        'Email wajib diisi.',

                    'valid_email' =>
                        'Format email tidak valid.',

                    'max_length' =>
                        'Email maksimal 150 karakter.',

                    'is_unique' =>
                        'Email sudah digunakan oleh anggota lain.',
                ],
            ],


            'phone' => [
                'rules' =>
                    'permit_empty|max_length[25]',
            ],


            'address' => [
                'rules' =>
                    'permit_empty|max_length[500]',
            ],


            'status' => [
                'rules' =>
                    'required|in_list[active,inactive]',

                'errors' => [
                    'required' =>
                        'Status anggota wajib dipilih.',

                    'in_list' =>
                        'Status anggota tidak valid.',
                ],
            ],
        ];


        if (! $this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }


        $data = [

            'member_code' => trim(
                (string)
                $this->request->getPost(
                    'member_code'
                )
            ),

            'name' => trim(
                (string)
                $this->request->getPost(
                    'name'
                )
            ),

            'email' => trim(
                (string)
                $this->request->getPost(
                    'email'
                )
            ),

            'phone' => trim(
                (string)
                $this->request->getPost(
                    'phone'
                )
            ) ?: null,

            'address' => trim(
                (string)
                $this->request->getPost(
                    'address'
                )
            ) ?: null,

            'status' =>
                $this->request->getPost(
                    'status'
                ),
        ];


        $memberModel->update(
            $id,
            $data
        );


        return redirect()
            ->to(site_url('anggota'))
            ->with(
                'success',
                'Data anggota berhasil diperbarui.'
            );
    }


    /**
     * =========================================================
     * HAPUS ANGGOTA
     * =========================================================
     */
    public function delete($id)
    {
        $memberModel = new MemberModel();

        $member = $memberModel->find($id);


        if ($member === null) {

            throw PageNotFoundException::forPageNotFound(
                'Data anggota tidak ditemukan.'
            );
        }


        $memberModel->delete($id);


        return redirect()
            ->to(site_url('anggota'))
            ->with(
                'success',
                'Data anggota berhasil dihapus.'
            );
    }
}
