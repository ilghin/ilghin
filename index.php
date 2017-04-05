<?php
	require_once('config.php');
	require_once('handler.php');

	//$title = $XML->rdf_RDF->owl_Ontology->rdfs_Comment;
?>
    <!DOCTYPE html>
    <html lang="ru">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <head>
        <meta charset="UTF-8">
        <title>
            Thing
        </title>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <?php
		$select_array = array();

		foreach ($XML->owl_Class as $class) {
			foreach ($class->rdfs_subClassOf as $subClassOf) {
			    if($subClassOf['rdf_resource']=="http://www.semanticweb.org/alezi/ontologies/2017/2/ontology#Программирование"){
                    $select_array[] = str_replace(PREFIX, '', $class['rdf_about']);
                }
                $select_array[] = str_replace(PREFIX, '', $subClassOf['rdf_resource']);
			}
		}

		$unique_select_array = array_unique($select_array);

		foreach ($XML->owl_Class as $class) :
			$rdf_about = str_replace(PREFIX, '', $class['rdf_about']);
	?>
            <div class="col-xs-12 col-md-6">
                    <p><strong><?= $rdf_about ?></strong></p>
                    <form action="/" class="owl_Class update" method="POST">
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="id" value="<?= $rdf_about; ?>">
                            <label for="">Термин</label>
                            <input class="form-control" type="text" name="rdf_about" value="<?= $rdf_about; ?>">
                            <label for="">Класс</label>
                            <?php
			$rdf_resource = str_replace(PREFIX, '', $class->rdfs_subClassOf['rdf_resource']);
			$select_html = '<select name="subClassOf" class="form-control">';
	
			foreach ($unique_select_array as $unique) {
				$select_html .= '<option value="' . $unique . '"';

				if ($rdf_resource == $unique) {
					$select_html .= ' selected="">' . $unique . '</option>';
				} else {
					$select_html .= '>' . $unique . '</option>';
				}
			}

			$select_html .= '</select>';
			
			echo $select_html;
		?>
                                <br>
                                <label for="">Комментарий</label>
                                <br>
                                <textarea name="rdfs_comment" id="" class="form-control">
                                    <?= $class->rdfs_comment ?>
                                </textarea>
                                <br>
                                <input type="hidden" name="action" value="update">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                        </div>
                    </form>
                    <form action="/" class="remove" method="POST">
                        <input type="hidden" name="id" value="<?= $rdf_about; ?>">
                        <input type="hidden" name="action" value="remove">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
            </div>

                    <?php endforeach; ?>
            </div>
            <div class="row">
                        <h2>Добавить определение</h2>
                        <form action="/" class="add" method="POST">
                            <div class="form-group">
                                <label for="">Термин</label>
                                <input class="form-control" type="text" name="rdf_about" placeholder="Термин">
                                <label for="">Категория</label>
                                <?= $select_html ?>
                                    <label for="">Определение</label>
                                    <textarea class="form-control" name="rdfs_comment" id="" cols="30" rows="10"></textarea>
                                    <input type="hidden" name="action" value="add">
                                    <button type="submit" class="btn btn-primary" style="margin-top:15px">Добавить</button>
                            </div>
                        </form>
            </div>

        </div>
    </body>

    </html>