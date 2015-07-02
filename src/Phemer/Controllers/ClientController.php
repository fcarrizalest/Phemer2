<?php
namespace Phemer\Controllers;

class ClientController{


    public function routes(){

        return function(){
            $app = \Slim\Slim::getInstance();

            $clientController = new \Phemer\Controllers\ClientController();

            $app->get("/", $clientController->Index() );

             $app->get('/:id', $clientController-> GetClientById() );

            $app->post('/', $clientController-> PostNewClient() );

            $app->put('/:id', $clientController-> PostEditClient() );


            $app->delete('/:id', $clientController->PostDeleteClient() );

        };




    }


    public function GetClientById(){
        return function($id){
            $app = \Slim\Slim::getInstance();
            $app->log->debug("GetClientById clientController");

             $client =  \Client::find($id);


             echo $client->toJson();
        };
    }
	public function Index(){
        return function(){
            $app = \Slim\Slim::getInstance();
            
            $app->log->debug("Index clientController");

            
            $array = array();

            $start = $app->request->get('start');
            $length = $app->request->get('length');
            $search = $app->request->get('search');
            $order = $app->request->get('order');
            $columns = $app->request->get('columns');

            //if ( is_null( $search) )
            $clients =  \Client::query();

            if($search['value'] != ""){
                $clients->where('title', 'like', '%'.$search['value'].'%');
                //$clients->where('firstname', 'like', '%'.$search['value'].'%');
                
                $total =  $clients->get();
                
               
            }
          
            $clients->orderBy(  $columns [ $order[0]['column'] ]['data'] ,$order[0]['dir']  ) ;
            

            if($start != 0 )
                 $clients->skip($start);

            $clients->take($length );

            $clients = $clients->get();



            $array['draw'] = $app->request->get('draw');

            $array["recordsTotal"] =  count(  \Client::all() );
            if($search['value'] != ""){
                $array["recordsFiltered"] = count(   $total  );
            }else{
                $array["recordsFiltered"] =  $array["recordsTotal"];
            }
            

            $array['data'] = $clients->toArray();


          
                
           


            
             

            
            echo json_encode( $array );


        };
    }

     public function PostDeleteClient(){

        return function($id){
            $app = \Slim\Slim::getInstance();

            try {
                 $model = \Client::findOrFail($id);
                 $model->forceDelete();

                

            } catch (\Exception $e) {
            

            }
            //$app->redirect( $app->INETROOT.'/people');
        }; 
    }


    public function PostEditClient(){

        return function($id){
            $app = \Slim\Slim::getInstance();
            $app->log->debug("Entramos A PostEditClient ");

            try    {


                $body = $app->request->getBody();
                 $app->log->debug("Datos Recibidos: <pre>". print_r( $body,true ). "</pre>");
                $data = json_decode($body,true);
                
                //$data['firstname'] = $app->request->post('firstname');
                $rules['firstname'] = "required";

                
                //$data['lastname'] =  $app->request->post('lastname') ;
                //$rules['email'] = "required|email";
                //$data['title'] = $app->request->post('title');
                $rules['title'] = "required";


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

                $model = \Client::findOrFail($id);
               
                $model->firstname = $data['firstname'];
 
                $model->lastname = $data['lastname'];
                $model->title = $data['title'];
               

               

                $model->save();

            
                    
                
            } catch (\Exception $e) {
            	$app->flash("error", " " . $e->getMessage());
                
                $app->log->error( $e->getMessage()) ;
                
            }

            // $app->redirect( $app->INETROOT.'/people');
        };
    }

    public function PostNewClient(){
        return function(){
            $app = \Slim\Slim::getInstance();

            try {

                $body = $app->request->getBody();
                $data = json_decode($body,true);

                //$data['firstname'] = $app->request->post('firstname');
                $rules['firstname'] = "required";

                
                //$data['lastname'] =  $app->request->post('lastname') ;
                //$rules['email'] = "required|email";
                //$data['title'] = $app->request->post('title');
                $rules['title'] = "required";

                $messages = array(
                    'required' => 'El :attribute es obligatorio.',
                    'unique'  => "El :attribute ya existe "
                );

                echo '<pre>';

                print_r(  $data );
                echo '</pre>';
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
                $array['firstname'] = $data['firstname'];
                $array['lastname'] = $data['lastname'];

                $array['title'] = $data['title'];
                


                $user = new \Client( $array );

                $user->save();


               


                
            } catch (\Exception $e) {

            	$app->flash("error", " " . $e->getMessage());
                
                echo "error".     $e->getMessage();

                $app->log->error( $e->getMessage()) ;
            }


            echo "ok";


            //$app->redirect( $app->INETROOT.'/people');



        };
    }



}

