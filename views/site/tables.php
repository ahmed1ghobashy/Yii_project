<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $message = Yii::$app->session->getFlash('message');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yii</title>
</head>
<body>
    <h2>Services</h2>
    <table class="table table-striped mb-3">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($services as $service):?>
            <tr>
                <th scope="row"><?= $service->id?></th>
                <td><?= $service->name?></td>
                <td><?= $service->price?></td>
                <td>
                    <?= Html::a("Delete", ["/deleteService", "id" => $service->id], ["class" => "btn btn-danger"])?>
                </td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
    <div class="row">
        <div class="col">
            <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#ServiceCollapse" aria-expanded="false" aria-controls="multiCollapseExample1">Add new service</button>
        </div>
        <div class="col">
            <?= Html::a("Query Services where price >= 100", ["/queryServices1"], ["class" => "btn btn-primary"])?>
        </div>
        <div class="col">
            <?= Html::a("Qurey all services with no labors", ["/queryServices2"], ["class" => "btn btn-primary"])?>
        </div>
    </div>
    <div class="collapse multi-collapse" id="ServiceCollapse">
        <div class="card card-body">
            <?php $form = ActiveForm::begin(["action" => "/createService"])?>
            <?= $form->field($service, "name")->textInput(["value" => ""])?>
            <?= $form->field($service, "price")->textInput(["value" => ""])?>
            <?= Html::submitButton("Add service", ["class" => "btn btn-primary"])?>
            <?php ActiveForm::end()?>
        </div>
    </div>

    <h2>Labors</h2>
    <table class="table table-striped mb-3">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Service Id</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($labors as $labor):?>
            <tr>
                <th scope="row"><?= $labor->id?></th>
                <td><?= $labor->name?></td>
                <td><?= $labor->service_id?></td>
                <td>
                    <?= Html::a("Delete", ["/deleteLabor", "id" => $labor->id], ["class" => "btn btn-danger"])?>
                </td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>

    <?php if($message):?>
        <div class="alert alert-danger" role="alert">
            <?= $message?>
        </div>
    <?php endif?>
    <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#laborCollapse" aria-expanded="false" aria-controls="multiCollapseExample2">Add new labor</button>
    <div class="collapse multi-collapse mb-3" id="laborCollapse">
        <div class="card card-body">
            <?php $form = ActiveForm::begin(["action" => "/createLabor"])?>
            <?= $form->field($labor, "name")->textInput(["value" => ""])?>
            <?= $form->field($labor, "service_id")->textInput(["value" => ""])?>
            <?= Html::submitButton("Create Labor", ["class" => "btn btn-primary"])?>
            <?php ActiveForm::end()?>
        </div>
    </div>
</body>
</html>