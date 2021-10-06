<?= $this->extend('layouts/backend/index') ?>

<!-- Title -->
<?= $this->section('title') ?>
Dashboard Page
<?= $this->endSection() ?>
<!-- end Title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-header -->
<?= $this->section('content-header'); ?>
<?= $this->endSection(); ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<?= $this->endSection(); ?>
<!-- end Content-body -->