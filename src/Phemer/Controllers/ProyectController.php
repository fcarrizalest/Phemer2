<?php
namespace Phemer\Controllers;

class ProyectController{


    public function routes(){

        return function(){
            $app = \Slim\Slim::getInstance();

            $proyectController = new \Phemer\Controllers\ProyectController();

            $app->get("/", $proyectController->Index() );
            
            $app->get('/:id', $proyectController-> GetProyectById() );

            $app->post('/', $proyectController-> PostNewProyect() );

            $app->put('/:id', $proyectController-> PostEditProyect() );


            $app->delete('/:id', $proyectController->PostDeleteProyect() );

        };




    }


    public function GetProyectById(){
        return function($id){
            $app = \Slim\Slim::getInstance();
            $app->log->debug("GetProyectById proyectController");

             $client =  \Proyect::find($id);


             echo $client->toJson();
        };
    }
	public function Index(){
        return function(){
            $app = \Slim\Slim::getInstance();
            
            $app->log->debug("Index proyectController");

            
            $array = array();

            $start = $app->request->get('start');
            $length = $app->request->get('length');
            $search = $app->request->get('search');
            $order = $app->request->get('order');
            $columns = $app->request->get('columns');

            //if ( is_null( $search) )
            $proyects =  \Proyect::query();

            if($search['value'] != ""){
                $proyects->where('name', 'like', '%'.$search['value'].'%');
                //$clients->where('firstname', 'like', '%'.$search['value'].'%');
                
                $total =  $proyects->get();
                
               
            }
          
            $proyects->orderBy(  $columns [ $order[0]['column'] ]['data'] ,$order[0]['dir']  ) ;
            

            if($start != 0 )
                 $proyects->skip($start);

            $proyects->take($length );

            $proyects = $proyects->get();



            $array['draw'] = $app->request->get('draw');

            $array["recordsTotal"] =  count(  \Proyect::all() );
            if($search['value'] != ""){
                $array["recordsFiltered"] = count(   $total  );
            }else{
                $array["recordsFiltered"] =  $array["recordsTotal"];
            }
            

            $array['data'] = $proyects->toArray();
            
            $app->log->debug("Datos a enviar: <pre>" .print_r( $array,true). '</pre>' );
            echo json_encode( $array );


        };
    }

     public function PostDeleteProyect(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {
                 $model = \Proyect::findOrFail($id);
                 $model->forceDelete();

                

            } catch (\Exception $e) {
            

            }

            
            echo json_encode( array("success" => true ));

            //$app->redirect( $app->INETROOT.'/people');
        }; 
    }


    public function PostEditProyect(){

        return function($id){
            $app = \Slim\Slim::getInstance();
            $app->log->debug("Entramos A PostEditProyect ");

            try{


                $body = $app->request->getBody();
                $app->log->debug("Datos Recibidos: <pre>". print_r( $body,true ). "</pre>");
                $data = json_decode($body,true);
                
                //$data['firstname'] = $app->request->post('firstname');
                $rules['name'] = "required";

                
                //$data['lastname'] =  $app->request->post('lastname') ;
                //$rules['email'] = "required|email";
                //$data['title'] = $app->request->post('title');
                //$rules['title'] = "required";


                $validator = $app->Validator->make( $data, $rules ) ;

                if ($validator->fails())
                {
                    // The given data did not pass validation
                    $messages = $validator->messages();
                    $m = " ";
                    foreach ($messages->all('<li>:message</li>') as $message)
                    {
                        $m .= $message;
                    }
                    
                    throw new \Exception($m , 1);
                    
                }

                $model = \Proyect::findOrFail($id);
               
                $model->name = $data['name'];
 
                $model->description = $data['description'];
                $model->active = true;
               

               

                $model->save();

                $app->log->debug("nuevos datos: <pre>" . print_r( $client->toArray() , true). "</pre>" );
                echo json_encode( array("success" => true ));

                    
                
            } catch (\Exception $e) {
            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
                
            }

            // $app->redirect( $app->INETROOT.'/people');
        };
    }

    public function PostNewProyect(){
        return function(){
            $app = \Slim\Slim::getInstance();

            try {

                $body = $app->request->getBody();

                $app->log->debug("Datos Recibidos: <pre>". print_r( $body,true ). "</pre>");
               
                $data = json_decode($body,true);

                //$data['firstname'] = $app->request->post('firstname');
                $rules['name'] = "required";

                

                $messages = array(
                    'required' => 'El :attribute es obligatorio.',
                    'unique'  => "El :attribute ya existe "
                );

                
                $validator = $app->Validator->make( $data, $rules  ) ;

                if ($validator->fails())
                {
                    // The given data did not pass validation
                    $messages = $validator->messages();
                    $m = " ";
                    foreach ($messages->all(":message ") as $message)
                    {
                        $m .= $message ;
                    }
                    
                    throw new \Exception($m , 1);
                    
                }

                // @TODO Validar los datos de entrada..
                $array['name'] = $data['name'];
                $array['description'] = $data['description'];

                $array['active'] = true;
            
                $proyect = new \Proyect( $array );

                $proyect->save();

                
            } catch (\Exception $e) {

            	$app->flash("error", " " . $e->getMessage());
                
               // echo "error".     $e->getMessage();

                $app->log->error( $e->getMessage()) ;
            }


            echo json_encode( array("success" => true ));


            //$app->redirect( $app->INETROOT.'/people');



        };
    }



}

