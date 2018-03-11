<?php

Breadcrumbs::register('admin.auth.news.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.news_management.news.management'), route('admin.auth.news.index'));
});

Breadcrumbs::register('admin.auth.news.delete', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.news.index');
    $breadcrumbs->push(__('menus.backend.news_management.news.deleted'), route('admin.auth.news.delete'));
});

Breadcrumbs::register('admin.auth.news.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.news.index');
    $breadcrumbs->push(__('labels.backend.news_management.news.create'), route('admin.auth.news.create'));
});

Breadcrumbs::register('admin.auth.news.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.news.index');
    $breadcrumbs->push(__('menus.backend.news_management.news.view'), route('admin.auth.news.show', $id));
});

Breadcrumbs::register('admin.auth.news.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.news.index');
    $breadcrumbs->push(__('menus.backend.news_management.news.edit'), route('admin.auth.news.edit', $id));
});

