<?php
include('headerFooter/header.php');
include('../class/category.class.php');
include('../class/news.class.php');

$category = new Category();
$categoryList = $category->retrieve();

$news = new News();

@session_start();
if (isset($_POST['submit'])) {

    $news->set('title', $_POST['title']);
    $news->set('short_detail', $_POST['short_detail']);
    $news->set('detail', $_POST['detail']);
    $news->set('featured', $_POST['featured']);
    $news->set('breaking', $_POST['breaking']);
    $news->set('status', $_POST['status']);
    $news->set('slider_key', $_POST['slider_key']);
    $news->set('category_id', $_POST['category_id']);
    $news->set('created_by', $_SESSION['id']);
    $news->set('created_date', date('Y-m-d H:i:s'));
    if ($_FILES['image']['error'] == 0) {
        if ($_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/jpeg") {
            if ($_FILES['image']['size'] <= 1024 * 1024) {
                $imageName = uniqid() . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $imageName);
                $news->set('image', $imageName);
            } else {
                $imageError = "Error, Exceeded 1Mb!";
            }
        } else {
            $imageError = "Invalid Image!";
        }
    }
    $result = $news->save();
    if (is_integer($result)) {
        $ErrMs = "";
        $msg = "News inserted saved Successfully with id " . $result;
    } else {
        $msg = "";
    }
}
include('sideBar.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">List News</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if (isset($msg)) { ?>
                <div class="alert alert-success"><?php echo $msg; ?></div>
            <?php } ?>
            <?php if (isset($ErrMsg)) { ?>
                <div class="alert alert-danger"><?php echo $ErrMsg; ?></div>
            <?php } ?>
        </div>
    </div>
</div>