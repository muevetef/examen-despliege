<?php

namespace App\Controllers;

use Core\Authorization;
use Core\Database;
use Core\Session;
use Core\Validation;

class TrastoController
{
    protected $db;

    function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    function index()
    {

        $trastos = $this->db->query('SELECT * FROM trastos ORDER BY created_at DESC')->fetchall();

        //Pasarlos a la vista home y cargar la vista
        loadView('trastos/index', [
            'trastos' => $trastos
        ]);
    }

    function show($params)
    {
        $trasto = $this->db->query('SELECT * FROM trastos WHERE id = :id', $params)->fetch();
        if (!$trasto) {
            ErrorController::notFound('No se encuentra el trasto');
            return;
        }
        loadView('trastos/show', [
            'trasto' => $trasto
        ]);
    }

    function create()
    {
        loadView('trastos/create');
    }

    function store()
    {
        //asegurar que llegan todo los campos requeridos o válidos
        $allowedFields = ['title', 'description', 'details', 'price', 'condition', 'category', 'tags', 'seller', 'address', 'city', 'state', 'phone', 'email'];

        $newTrastoData = array_intersect_key($_POST, array_flip($allowedFields));
        //sanitizar los valores de todos los campos
        $newTrastoData = array_map('sanitize', $newTrastoData);

        $newTrastoData['user_id'] = Session::get('user')['id'];
        //SUBIR LA IMAGEN A LA CARPETA Y GUARDAR LA RUTA


        $requiredFields = ['title', 'description', 'email', 'city'];
        //recorrer los campos requerido  y guardar los errores si los hay
        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($newTrastoData[$field]) || !Validation::string($newTrastoData[$field])) {
                $errors[$field] = 'El valor no es un texto válido';
            }
        }

        //si hay errores los pasamos a la vista
        if ($errors) {
            loadView('trastos/create', ['errors' => $errors, 'trastos' => $newTrastoData]);
        } else {
            //sinó hay errores guardamos el trasto
            // $this->db->query("INSERT INTO `trastos` (`user_id`, `title`, `description`, `details`, `price`, `condition`, `category`, `tags`, `seller`, `address`, `city`, `state`, `phone`, `email`) VALUES (:user_id, :title, :description, :details, :price, :condition, :category, :tags, :seller, :address, :city, :state, :phone, :email)", $newTrastoData);

            $fields = [];
            //Tenemos que convertir los valores vacios a null
            foreach ($newTrastoData as $field => $value) {
                $fields[] = '`' . $field . '`';
            }
            $fields = implode(', ', $fields);

            $values = [];
            foreach ($newTrastoData as $field => $value) {
                //passar los strings vacios a null
                if ($value === '') {
                    $newTrastoData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);


            $query = "INSERT INTO trastos ($fields) VALUES ($values)";
            $this->db->query($query, $newTrastoData);
            //si no hay error redireccionar a /trastos

            Session::setFlashMessage('success_message', 'Trasto añadido correctamente');
            redirect('/trastos');
        }
    }

    function delete($params)
    {
        $trasto = $this->db->query('SELECT * FROM trastos WHERE id = :id', $params)->fetch();
        if (!$trasto) {
            ErrorController::notFound('No se encuentra el trasto');
            return;
        }

        //Comprobar si somos el autor
        if (!Authorization::isOwner($trasto->user_id)) {
            //TODO mostrar un mensage de error
            Session::setFlashMessage('error_message', 'No tienes autorización');
            return redirect('/trasto/' . $trasto->id);
        }

        $this->db->query('DELETE FROM trastos WHERE id = :id', $params);

        Session::setFlashMessage('success_message', 'Trasto eliminado correctamente');
        redirect('/trastos');
    }

    function edit($params)
    {
        $trasto = $this->db->query('SELECT * FROM trastos WHERE id = :id', $params)->fetch();
        if (!$trasto) {
            ErrorController::notFound('No se encuentra el trasto');
            return;
        }
        //Comprobar si somos el autor
        if (!Authorization::isOwner($trasto->user_id)) {
            //TODO mostrar un mensage de error
            Session::setFlashMessage('error_message', 'No tienes autorización');
            return redirect('/trasto/' . $trasto->id);
        }
        loadView('trastos/edit', [
            'trasto' => $trasto
        ]);
    }

    function update($params)
    {

        //Comprobar que el trasto para actualizar existe
        $trasto = $this->db->query('SELECT * FROM trastos WHERE id = :id', $params)->fetch();
        if (!$trasto) {
            ErrorController::notFound('No se encuentra el trasto');
            return;
        }

        //Comprobar si somos el autor
        if (!Authorization::isOwner($trasto->user_id)) {
            //TODO mostrar un mensage de error
            Session::setFlashMessage('error_message', 'No tienes autorización');
            return redirect('/trasto/' . $trasto->id);
        }

        //asegurar que llegan todo los campos requeridos o válidos
        $allowedFields = ['title', 'description', 'details', 'price', 'condition', 'category', 'tags', 'seller', 'address', 'city', 'state', 'phone', 'email'];

        $updateTrastoData = array_intersect_key($_POST, array_flip($allowedFields));
        //sanitizar los valores de todos los campos
        $updateTrastoData = array_map('sanitize', $updateTrastoData);

        $requiredFields = ['title', 'description', 'email', 'city'];

        $updateTrastoData['id'] = $trasto->id; //añadimos el id al array

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updateTrastoData[$field]) || !Validation::string($updateTrastoData[$field])) {
                $errors[$field] = 'El valor no es un texto válido';
            }
        }


        //si hay errores los pasamos a la vista
        if ($errors) {
            loadView('trastos/edit', ['errors' => $errors, 'trasto' => (object)$updateTrastoData]);
            exit;
        } else {
            //sinó hay errores guardamos el trasto
            $updateFields = [];
            //Tenemos que convertir los valores vacios a null
            foreach (array_keys($updateTrastoData) as $field) {
                $updateFields[] = "`$field` = :$field";
            }
            $updateFields = implode(', ', $updateFields);

            $values = [];
            foreach ($updateTrastoData as $field => $value) {
                //passar los strings vacios a null
                if ($value === '') {
                    $updateTrastoData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);


            $query = "UPDATE trastos SET $updateFields WHERE id = :id";
            // inspectAndDie($query);


            $this->db->query($query, $updateTrastoData);
            //si no hay error redireccionar a /trastos
            Session::setFlashMessage('success_message', 'Trasto editado correctamente');
            redirect('/trasto/' . $trasto->id);
        }
    }
}
