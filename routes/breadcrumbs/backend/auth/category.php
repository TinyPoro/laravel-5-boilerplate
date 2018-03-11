<?php

Breadcrumbs::register('admin.auth.category.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.news_management.category.management'), route('admin.auth.category.index'));
});

Breadcrumbs::register('admin.auth.category.delete', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.category.index');
    $breadcrumbs->push(__('menus.backend.news_management.category.deleted'), route('admin.auth.category.delete'));
});

Breadcrumbs::register('admin.auth.category.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.category.index');
    $breadcrumbs->push(__('labels.backend.news_management.category.create'), route('admin.auth.category.create'));
});

Breadcrumbs::register('admin.auth.category.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.category.index');
    $breadcrumbs->push(__('menus.backend.news_management.category.view'), route('admin.auth.category.show', $id));
});

Breadcrumbs::register('admin.auth.category.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.category.index');
    $breadcrumbs->push(__('menus.backend.news_management.category.edit'), route('admin.auth.category.edit', $id));
});

