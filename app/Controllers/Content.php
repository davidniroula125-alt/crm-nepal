<?php namespace App\Controllers;

use App\Models\SiteContent;

class Content extends BaseController
{
    public function index()
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $contentModel = new SiteContent();
        $content = $contentModel->orderBy('section', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
        
        return view('pages/content', ['content' => $content]);
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        return view('pages/content_form', ['item' => null]);
    }

    public function store()
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $contentModel = new SiteContent();
        
        $contentModel->insert([
            'section' => $this->request->getPost('section'),
            'key_name' => $this->request->getPost('key_name'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon' => $this->request->getPost('icon'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('content_created', 'site_content', $contentModel->insertID());
        
        return redirect()->to('/content');
    }

    public function edit($id)
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $contentModel = new SiteContent();
        $item = $contentModel->find($id);
        
        if (!$item) {
            return redirect()->to('/content');
        }
        
        return view('pages/content_form', ['item' => $item]);
    }

    public function update($id)
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $contentModel = new SiteContent();
        
        $contentModel->update($id, [
            'section' => $this->request->getPost('section'),
            'key_name' => $this->request->getPost('key_name'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon' => $this->request->getPost('icon'),
            'sort_order' => $this->request->getPost('sort_order'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('content_updated', 'site_content', $id);
        
        return redirect()->to('/content');
    }

    public function delete($id)
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $contentModel = new SiteContent();
        $contentModel->delete($id);
        log_activity('content_deleted', 'site_content', $id);
        
        return redirect()->to('/content');
    }

    public function toggle($id)
    {
        if (!isAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $contentModel = new SiteContent();
        $item = $contentModel->find($id);
        
        if ($item) {
            $contentModel->update($id, [
                'is_active' => $item['is_active'] ? 0 : 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        
        return redirect()->to('/content');
    }
}
