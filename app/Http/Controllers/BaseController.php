<?php


namespace App\Http\Controllers;

use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Make Model instance
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $model = $this->model->newInstance($request->all());
        $model->save();

        return $model;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function list()
    {
        $modelClass = $this->model->newInstance();

        return $modelClass::with('dogs')->get();
    }

}
