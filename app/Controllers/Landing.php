<?php namespace App\Controllers;

use App\Models\SiteContent;

class Landing extends BaseController
{
    public function index()
    {
        $contentModel = new SiteContent();
        $features = $contentModel->getBySection('features');
        $localFeatures = $contentModel->getBySection('local_features');
        $faqs = $contentModel->getBySection('faq');

        return view('landing/index', [
            'features' => $features,
            'localFeatures' => $localFeatures,
            'faqs' => $faqs,
        ]);
    }
}
