<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header"><?php echo $title; ?></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <form action="/admin/edit/<?=$vars['data'][0]['id'];?>" method="post">
                            <div class="form-group">
                                <label>Название</label>
                                <input class="form-control" type="text"
                                    value="<?= htmlspecialchars($vars['data'][0]['name']);?>" name="name">
                            </div>
                            <div class="form-group">
                                <label>Описание</label>
                                <input class="form-control" type="text"
                                    value="<?= htmlspecialchars($vars['data'][0]['description']);?>" name="description">
                            </div>
                            <div class="form-group">
                                <label>Текст</label>
                                <textarea class="form-control" rows="3"
                                    name="text"><?= htmlspecialchars($vars['data'][0]['text']);?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Изображение</label>
                                <input class="form-control" type="file" name="img">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>