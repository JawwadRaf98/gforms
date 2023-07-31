<?php
    include_once('header.php');
?>
<style>
    body{
        background-color: #d5d3d578;
    }
</style>

<div class="container">
    <div class="add-form">
        <form action="" method="POST">

            <div class="section section-title">
                <div class="input">
                    <input type="text" name="form-title" value="Add Title" class="title main-title"/>
                    <textarea name="desc" id="desc" placeholder="Add a description"></textarea>
                </div>
            </div>

            <div id="questioniar">

                <div class="Question">
                    <div class="section">
                        <div class="top">
                            <div class="left" data-id="1">Question no 1</div>
                            <div class="right">
                                <select name="type" class="type">
                                <option value="1">Question</option>
                                <option value="2">MCQ's (Single Choice)</option>
                                <option value="3">MCQ's (Multi Choice)</option>
                                <option value="4">Detailed Question</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>