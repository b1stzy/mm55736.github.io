<?php
namespace App\Controller;

use App\Model\Car;
use App\Service\Templating;
use App\Service\Router;

class CarController
{
    public function indexAction(Templating $templating, Router $router)
    {
        $cars = Car::findAll();
        return $templating->render('car/index.html.php', ['cars' => $cars]);
    }

    public function showAction(int $id, Templating $templating, Router $router)
    {
        $car = Car::find($id);
        return $templating->render('car/show.html.php', ['car' => $car]);
    }

    public function createAction(?array $data, Templating $templating, Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $car = new Car();
            $car->setBrand($data['brand']);
            $car->setModel($data['model']);
            $car->setYear((int)$data['year']);
            $car->save();

            $router->redirect('?action=car-index');
        }

        return $templating->render('car/create.html.php');
    }

    public function editAction(int $id, ?array $data, Templating $templating, Router $router)
    {
        $car = Car::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $car->setBrand($data['brand']);
            $car->setModel($data['model']);
            $car->setYear((int)$data['year']);
            $car->save();

            $router->redirect('?action=car-index');
        }

        return $templating->render('car/edit.html.php', ['car' => $car]);
    }

    public function deleteAction(int $id, Router $router)
    {
        $car = Car::find($id);
        if ($car) {
            $car->delete();
        }
        $router->redirect('?action=car-index');
    }
}
