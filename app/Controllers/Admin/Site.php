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
        try {
            $slug = $this->request->getGet('page') ?? 'home';

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

            try {
                $content = $this->model->getPageContent($slug);
            } catch (\Throwable $e) {
                log_message('error', 'Site content query error: ' . $e->getMessage());
                $content = [];
            }

            return view('admin/site/index', [
                'pageTitle' => 'Site Content',
                'pages'     => $pages,
                'currentPage' => $slug,
                'content'   => $content,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Site index error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return $this->response->setStatusCode(500)->setBody('Site Error: ' . $e->getMessage())->setHeader('Content-Type', 'text/plain');
        }
    }

    public function update()
    {
        $slug    = $this->request->getPost('slug');
        $updates = $this->request->getPost('content');

        try {
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
        } catch (\Throwable $e) {
            return redirect()->to("/admin/site?page={$slug}")->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }
}
