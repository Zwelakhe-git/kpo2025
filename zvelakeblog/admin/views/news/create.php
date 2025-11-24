<?php require_once 'views/layout/header.php'; ?>

<h2>Ajoute nouvel</h2>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="newsHeadline" class="form-label">News Headline *</label>
        <textarea type="text" class="form-control" id="newsHeadline" name="newsHeadline" required></textarea>
    </div>
    <div class="mb-3">
        <label for="newsCategory" class="form-label">Category *</label>
        <!--<input type="text" class="form-control" id="newsCategory" placeholder="politics, technology, entertainment, ..." name="newsCategory" required> -->
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
        <label for="newsTitle" class="form-label">Tit Nouvel *</label>
        <input type="text" class="form-control" id="newsTitle" name="newsTitle" required>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="newsDate" class="form-label">Dat nouvel *</label>
                <input type="date" class="form-control" id="newsDate" name="newsDate" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="news_image" class="form-label">Imaj nouvel</label>
                <input type="file" class="form-control" data-preview="news-prev-img" id="news_image" name="news_image" accept="image/*">
                <img id="news-prev-img" class="img-thumbnail" style="display:none;margin-top: 10px; width: 150px; height: 150px"/>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="fullContent" class="form-label">Full Content *</label>
        <textarea class="form-control" id="fullContent" name="fullContent" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Ajoute nouvel</button>
    <a href="?action=news" class="btn btn-secondary">Anile</a>
</form>

<script>
// Устанавливаем сегодняшнюю дату по умолчанию
document.getElementById('newsDate').value = new Date().toISOString().split('T')[0];
newsCategory = document.querySelector("select[id='newsCategory']");
if(newsCategory){
    newsCategory.addEventListener("change", function(){
        if(newsCategory.value == "new"){
            let inpElem = document.querySelector("input[id='newsCategory']");
            if(inpElem){
                inpElem.style.display = "block";
                newsCategory.style.display = "none";
            }
        }
    })
}
</script>

<?php require_once 'views/layout/footer.php'; ?>