<?php

namespace App\Controllers;

class Blog extends BaseController
{
    // NOTE: Full blog CMS (categories, tags, SEO fields, related posts) depends
    // on BlogPostModel / BlogCategoryModel which land with the admin CMS in Part 2.
    // These actions render placeholder views so routes/URLs are stable now.

    public function index(): string
    {
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'Blog | CRM Software Nepal',
            'pageTitle' => 'Blog',
            'note'      => 'Blog index (categories: CRM, Travel Technology, Travel Business, Digital Transformation, Sales, Customer Management, Nepal Travel Industry, Business Automation) — next build pass.',
        ]));
    }

    public function show(string $slug): string
    {
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'Blog | CRM Software Nepal',
            'pageTitle' => 'Blog Post',
            'note'      => "Single post view for slug '{$slug}' — next build pass.",
        ]));
    }

    public function category(string $slug): string
    {
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'Blog | CRM Software Nepal',
            'pageTitle' => 'Blog Category',
            'note'      => "Category archive for '{$slug}' — next build pass.",
        ]));
    }
}
