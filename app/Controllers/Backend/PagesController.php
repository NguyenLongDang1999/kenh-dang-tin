<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Pages;

class PagesController extends BaseController
{
    protected $pages;
    protected $slug;

    public function __construct()
    {
        $this->slug = new Slug();
        $this->pages = new Pages();
    }

    public function index()
    {
        return view('backend/pages/index');
    }

    public function getList()
    {
        $input = $this->request->getGet();
        $data = array();

        $results = $this->pages->getList($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'name'              => '<a class="text-capitalize text-body" data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . esc($row->name) . '" href="' . route_to('admin.pages.edit', $row->id) . '">' . character_limiter(esc($row->name), 15, '...') . '</a>',
                    'url'               => esc($row->url),
                    'status'            => esc($row->status),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'updated_at'        => esc(getDateTime($row->updated_at)),
                    'title'             => esc($row->name),
                    'editPages'         => route_to('admin.pages.edit', $row->id)
                ];
            }
        }

        return json_encode($data);
    }

    public function recycle()
    {
        return view('backend/pages/recycle');
    }

    public function getListRecycle()
    {
        $input = $this->request->getGet();
        $data = array();

        $results = $this->pages->getListRecycle($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'name'              => character_limiter(esc($row->name), 15, '...'),
                    'url'               => esc($row->url),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'updated_at'        => esc(getDateTime($row->updated_at)),
                    'title'             => esc($row->name),
                ];
            }
        }

        return json_encode($data);
    }

    public function reorder()
    {
        $data['getReorderPages'] = $this->pages->getReorderPages();
        return view('backend/pages/reorder', $data);
    }

    public function postOrder()
    {
        $result = $this->request->getPost('new_order');
        if (isset($result)) {
            foreach ($result as $key => $item) {
                if ($this->pages->update($item['id'], ['sort' => $key + 1])) {
                    $data['result'] = true;
                    $data['message'] = '<span class="text-capitalize">C???p nh???t v??? tr?? s???p x??p trang th??nh c??ng.</span>';
                }
            }

            return json_encode($data);
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function create()
    {
        return view('backend/pages/create_edit');
    }

    public function store()
    {
        $input = $this->request->getPost([
            'name',
            'status',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description'
        ]);

        if (is_null($input['status'])) {
            $input['status'] = STATUS_INACTIVE;
        }

        $input['url'] = $this->slug->str_slug($input['name']);

        $this->pages->insert($input);
        return redirect()->route('admin.pages.index')->with('success', "Page <strong class='text-capitalize'>" . esc($input['name']) . "</strong> ???? ???????c th??m.");
    }

    public function edit($id)
    {
        $data['row'] = $this->pages->getDetailPages($id);
        return view('backend/pages/create_edit', $data);
    }

    public function update($id)
    {
        $input = $this->request->getPost([
            'name',
            'status',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description'
        ]);

        if (is_null($input['status'])) {
            $input['status'] = STATUS_INACTIVE;
        }

        $input['url'] = $this->slug->str_slug($input['name']);

        $this->pages->update($id, $input);
        return redirect()->route('admin.pages.index')->with('success', "Page <strong class='text-capitalize'>" . esc($input['name']) . "</strong> ???? ???????c c???p nh???t.");
    }

    public function multiStatus()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">B???n kh??ng th??? g???i y??u c???u li??n t???c. Vui l??ng ch??? ' . $throttler->getTokentime() . ' gi??y</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        $status = $this->request->getPost('status');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
            if ($this->pages->update($result['chk'], ['status' => $status])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">C???p nh???t tr???ng th??i th??nh c??ng t???t c??? d??? li???u ???????c ch???n.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiDestroy()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">B???n kh??ng th??? g???i y??u c???u li??n t???c. Vui l??ng ch??? ' . $throttler->getTokentime() . ' gi??y</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            if ($this->pages->delete($result['chk'])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">X??a th??nh c??ng t???t c??? d??? li???u ???????c ch???n.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiPurgeDestroy()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">B???n kh??ng th??? g???i y??u c???u li??n t???c. Vui l??ng ch??? ' . $throttler->getTokentime() . ' gi??y</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            if ($this->pages->delete($result['chk'], true)) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">X??a v??nh vi???n th??nh c??ng t???t c??? d??? li???u ???????c ch???n.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiRestore()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">B???n kh??ng th??? g???i y??u c???u li??n t???c. Vui l??ng ch??? ' . $throttler->getTokentime() . ' gi??y</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            if ($this->pages->update($result['chk'], ['deleted_at' => NULL])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Kh??i ph???c th??nh c??ng t???t c??? d??? li???u ???????c ch???n.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function checkExists()
    {
        $name = $this->request->getPost('name');
        $slug = $this->slug->str_slug($name);
        $result = $this->pages->checkExists($slug);
        $valid = $result > 0 ? false : true;
        return $this->response->setJSON([
            'valid' => $valid,
        ]);
    }
}
