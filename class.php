<?php
require_once('config.php');
require_once('classhandler.php');

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
                $select_array[] = str_replace(PREFIX, '', $subClassOf['rdf_resource']);
            }
        }

        $unique_select_array = array_unique($select_array);

        /*foreach ($XML->owl_Class as $class) :
            $rdf_about = str_replace(PREFIX, '', $class['rdf_about']);
            */?>
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <?php
                        foreach ($unique_select_array as $unique) {
                            $input_html .='<form action="/" class="owl_Class update" method="POST">
                        <div class="form-group">';
                            $input_html .= '<label>Класс</label><input class="form-control" name="Class" value="' . $unique . '"></textarea>';
                            $input_html .= '</div>';
                            $input_html .= '<div class="form-group">';
                            $input_html .='<input type="hidden" name="action" value="update"><button type="submit" class="btn btn-primary">Обновить</button>';
                            $input_html .='</div></form>';
                            $input_html .= '<form action="/" class="remove" method="POST"><div class="form-group">';
                            $input_html .='<input type="hidden" name="action" value="remove"><button type="submit" class="btn btn-danger">Удалить</button></form>';
                            $input_html .= '</div></form>';
                        }

                        //$select_html .= '</select>';
                        echo $input_html;
                        ?>
            </div>
    </div>
</div>
</body>

</html>