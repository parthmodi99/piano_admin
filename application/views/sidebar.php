<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$this->CI =& get_instance();
$ad = $this->CI->session->userdata('admin');

$admin_type = $ad['admin_type'];

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- aside -->

<aside id="aside" class="app-aside hidden-xs bg-dark">

    <div class="aside-wrap">

        <div class="navi-wrap">

            <!-- user -->

            <div class="clearfix hidden-xs text-center hide" id="aside-user">

                <div class="dropdown wrapper">

                    <a href="app.page.profile">

                        <span class="thumb-lg w-auto-folded avatar m-t-sm">

                            <img src="<?= base_url('admintheme') ?>/img/a0.jpg" class="img-full" alt="...">

                        </span>

                    </a>

                    <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded">

                        <span class="clear">

                            <span class="block m-t-sm">

                                <strong class="font-bold text-lt">Admin</strong> 

                                <b class="caret"></b>

                            </span>



                        </span>

                    </a>

                    <!-- dropdown -->

                    <ul class="dropdown-menu animated fadeInRight w hidden-folded">





                        <li>

                            <a href="#">Profile</a>

                        </li>



                        <li class="divider"></li>

                        <li>

                            <a href="<?= base_url() . 'logout' ?>">Logout</a>

                        </li>

                    </ul>

                    <!-- / dropdown -->

                </div>

                <div class="line dk hidden-folded"></div>

            </div>

            <!-- / user -->



            <!-- nav -->

            <nav ui-nav class="navi clearfix">

                <ul class="nav">

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">

                        <span>Navigation</span>

                    </li>
                    <?php 
                    if($admin_type == 1)
                    {
                    ?>
                    <li class="<?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'dashboard' ?>">

                            <i class="glyphicon glyphicon-dashboard"></i>

                            <span>Dashboard</span>

                        </a>

                    </li>
                    

                    <li class="<?= $this->uri->segment(1) == 'SubAdmin' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'SubAdmin/list' ?>">

                            <i class="fa fa-shield"></i>

                            <span>Sub Admin</span>

                        </a>

                    </li>

                    <li class="<?= $this->uri->segment(1) == 'User' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'User/userlist' ?>">

                            <i class="fa fa-user"></i>

                            <span>Users</span>

                        </a>

                    </li>
                    <?php } ?>

                    <li class="<?= ($this->uri->segment(1) == 'Track') ? 'active' : '' ?>">

                        <a  href="#" class="auto">

                            <span class="pull-right text-muted">

                                <i class="fa fa-fw fa-angle-right text"></i>

                                <i class="fa fa-fw fa-angle-down text-active"></i>

                            </span>

                            <i class="fa fa-quote-right"></i>

                            <span class="font-bold">Track</span>

                        </a>

                        <ul class="nav nav-sub dk">

                            <li class="<?= ($this->uri->segment(1) == 'Track' && $this->uri->segment(2) == 'addTrack') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Track/addTrack' ?>">

                                    <span>Add New</span>

                                </a>

                            </li>

                            <li class="<?= ($this->uri->segment(1) == 'Track' && $this->uri->segment(2) == '') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Track' ?>">

                                    <span>Tracks List</span>

                                </a>

                            </li>

                        </ul>

                    </li>


                    <?php 
                    if($admin_type == 1)
                    {
                    ?>
                    <li class="<?= ($this->uri->segment(1) == 'Page') ? 'active' : '' ?>">

                        <a  href="#" class="auto">

                            <span class="pull-right text-muted">

                                <i class="fa fa-fw fa-angle-right text"></i>

                                <i class="fa fa-fw fa-angle-down text-active"></i>

                            </span>

                            <i class="fa fa-pencil-square-o"></i>

                            <span class="font-bold">Cms Pages</span>

                        </a>

                        <ul class="nav nav-sub dk">

                            <li class="<?= ($this->uri->segment(1) == 'Page' && $this->uri->segment(2) == 'addPage') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Page/addPage' ?>">

                                    <span>Add New</span>

                                </a>

                            </li>

                            <li class="<?= ($this->uri->segment(1) == 'Page' && $this->uri->segment(2) == '') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Page' ?>">

                                    <span>Pages List</span>

                                </a>

                            </li>

                        </ul>

                    </li>
                <?php } ?>

                <?php 
                    if($admin_type == 1)
                    {
                    ?>
                        <li class="<?= ($this->uri->segment(1) == 'Course') ? 'active' : '' ?>">

                        <a  href="#" class="auto">

                            <span class="pull-right text-muted">

                                <i class="fa fa-fw fa-angle-right text"></i>

                                <i class="fa fa-fw fa-angle-down text-active"></i>

                            </span>

                            <i class="fa fa-graduation-cap"></i>

                            <span class="font-bold">Course</span>

                        </a>

                        <ul class="nav nav-sub dk">

                            <li class="<?= ($this->uri->segment(1) == 'Course' && $this->uri->segment(2) == 'addCourse') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Course' ?>">

                                    <span>Levels</span>

                                </a>

                            </li>
                            <li class="<?= ($this->uri->segment(1) == 'Lession' && $this->uri->segment(2) == 'addLession') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Lession' ?>">

                                    <span>Chapters</span>

                                </a>

                            </li>
                            <li class="<?= ($this->uri->segment(1) == 'Chapter' && $this->uri->segment(2) == 'addChapter') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Chapter' ?>">

                                    <span>Lessons</span>

                                </a>

                            </li>

                            <!-- <li class="<?= ($this->uri->segment(1) == 'Track' && $this->uri->segment(2) == '') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Track' ?>">

                                    <span>Tracks List</span>

                                </a>

                            </li> -->

                        </ul>

                    </li>
                    <?php } ?>
                    <?php 
                    if($admin_type == 1)
                    {
                    ?>
                    

                    <li class="<?= $this->uri->segment(1) == 'TrackRequest' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'TrackRequest' ?>">

                            <i class="fa fa-exchange"></i>

                            <span>Track Request</span>

                        </a>

                    </li>

                    <li class="<?= $this->uri->segment(1) == 'Chat' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'Chat' ?>">

                            <i class="fa fa-comment"></i>

                            <span>Messages</span>

                        </a>

                    </li>
                    <?php } ?>

                    <!-- <li class="<?= $this->uri->segment(1) == 'Notification' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'Notification' ?>">

                            <i class="fa fa-bell"></i>

                            <span>Notification Management</span>

                        </a>

                    </li> -->

                    <!-- <li class="<?= $this->uri->segment(1) == 'Filter' ? 'active' : '' ?>">

                        <a href="<?= base_url() . 'Filter' ?>">

                            <i class="fa fa-filter"></i>

                            <span>Filter</span>

                        </a>

                    </li> -->

                    <!-- <li class="<?= ($this->uri->segment(1) == 'Page') ? 'active' : '' ?>">

                        <a  href="#" class="auto">      

                            <span class="pull-right text-muted">

                                <i class="fa fa-fw fa-angle-right text"></i>

                                <i class="fa fa-fw fa-angle-down text-active"></i>

                            </span>

                            <i class="fa fa-pencil-square-o"></i>

                            <span class="font-bold">Cms Pages</span>

                        </a>

                        <ul class="nav nav-sub dk">

                            <li class="<?= ($this->uri->segment(1) == 'Page' && $this->uri->segment(2) == 'addPage') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Page/addPage' ?>">

                                    <span>Add New</span>

                                </a>

                            </li>

                            <li class="<?= ($this->uri->segment(1) == 'Page' && $this->uri->segment(2) == '') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Page' ?>">

                                    <span>Pages List</span>

                                </a>

                            </li>

                        </ul>

                    </li>

                     <li class="<?= ($this->uri->segment(1) == 'Quote') ? 'active' : '' ?>">

                        <a  href="#" class="auto">      

                            <span class="pull-right text-muted">

                                <i class="fa fa-fw fa-angle-right text"></i>

                                <i class="fa fa-fw fa-angle-down text-active"></i>

                            </span>

                            <i class="fa fa-quote-right"></i>

                            <span class="font-bold">Monday Quotes</span>

                        </a>

                        <ul class="nav nav-sub dk">

                            <li class="<?= ($this->uri->segment(1) == 'Quote' && $this->uri->segment(2) == 'addQuote') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Quote/addQuote' ?>">

                                    <span>Add New</span>

                                </a>

                            </li>

                            <li class="<?= ($this->uri->segment(1) == 'Quote' && $this->uri->segment(2) == '') ? 'active' : '' ?>">

                                <a href="<?= base_url() . 'Quote' ?>">

                                    <span>Quotes List</span>

                                </a>

                            </li>

                        </ul>

                    </li> -->

                </ul></nav>

        </div>

    </div>

</aside>

<!-- / aside -->