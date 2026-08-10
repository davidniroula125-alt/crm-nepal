<?php

namespace App\Controllers\Admin;

use App\Models\SiteContentModel;

class Site extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SiteContentModel();
    }

    public function index()
    {
        $slug = $this->request->getGet('page') ?? 'home';
        $content = $this->model->getPageContent($slug);

        $pages = [
            'home'      => 'Home Page',
            'about'     => 'About Page',
            'features'  => 'Features Page',
            'solutions' => 'Solutions Page',
            'pricing'   => 'Pricing Page',
            'faq'       => 'FAQ Page',
            'contact'   => 'Contact Page',
            'demo'      => 'Demo Page',
            'settings'  => 'Site Settings',
        ];

        return view('admin/site/index', [
            'pageTitle' => 'Site Content',
            'pages'     => $pages,
            'currentPage' => $slug,
            'content'   => $content,
        ]);
    }

    public function update()
    {
        $slug    = $this->request->getPost('slug');
        $updates = $this->request->getPost('content');

        if (! empty($updates) && is_array($updates)) {
            foreach ($updates as $section => $fields) {
                if (is_array($fields)) {
                    foreach ($fields as $key => $value) {
                        $type = 'text';
                        if (is_array($value)) {
                            $type = $value['type'] ?? 'text';
                            $value = $value['value'] ?? '';
                        }
                        $this->model->setContent($slug, $section, $key, $value, $type);
                    }
                }
            }
        }

        return redirect()->to("/admin/site?page={$slug}")->with('success', 'Site content updated successfully.');
    }
}
