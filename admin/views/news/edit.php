<?php require_once 'views/layout/header.php'; ?>

<h2>Redije nouvel</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="newsHeadline" class="form-label">News Headline *</label>
        <textarea type="text" class="form-control" id="newsHeadline" name="newsHeadline" required><?= htmlspecialchars($news['newsHeadline'])?></textarea>
    </div>
    <div class="mb-3">
        <label for="newsCategory" class="form-label">Category *</label>
       
        <!--<input type="text" class="form-control" id="newsCategory" value="<?= $news['newsCategory']?>" name="newsCategory" required>-->
        <select class="form-control" id="newsCategory" name='newsCategory'>
            <option value='sports'>Sports</option>
            <option value='entertainment'>Entertainment</option>
            <option value='politics'>Politics</option>
            <option value='science'>Science</option>
            <option value='business'>Business</option>
            <option value='technology'>Technology</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="newsTitle" class="form-label">Tit nouvel *</label>
        <input type="text" class="form-control" id="newsTitle" name="newsTitle" 
               value="<?= htmlspecialchars($news['newsTitle'] ?? '') ?>" required>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="newsDate" class="form-label">Dat nouvel *</label>
                <input type="date" class="form-control" id="newsDate" name="newsDate" 
                       value="<?= $news['newsDate'] ?? '' ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="news_image" class="form-label">Imaj nouvel</label>
                <input type="file" class="form-control" id="news_image" name="news_image" accept="image/*">
                <?php if ($news['image_location']): ?>
                <div class="mt-2">
                    <p>Imaj aktyel:</p>
                    <img src="<?= $news['image_location'] ?>" width="200" class="img-thumbnail">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="fullContent" class="form-label">Full Content *</label>
        <textarea class="form-control" id="fullContent" name="fullContent" required><?= htmlspecialchars($news['fullContent']) ?>
        </textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Renouvle imaj</button>
    <a href="?action=news" class="btn btn-secondary">Anile</a>
</form>

<script>
newsCategory = document.querySelector("select[id='newsCategory']");
if(newsCategory){
    newsCategory.addEventListener("change", function(){
        if(newsCategory.value == "new"){
            let inpElem = document.querySelector("input[id='newsCategory-inpe']");
            if(inpElem){
                inpElem.style.display = "block";
                newsCategory.style.display = "none";
            }
        }
    })
}
</script>
<?php require_once 'views/layout/footer.php'; ?>