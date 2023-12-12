<?php

namespace Core;

use Routing\RouterInterface;

class Application
{

    private $mvcContext;
    private $uri;

    private $serverInfo;
    /**
     * @var RouterInterface
     */
    private $router;


    private $dependencies = [];

    private $resolveDependencies = [];



    public function __construct(MvcContextInterface $mvcContext , $uri, $serverInfo, RouterInterface $router)
    {
        $this->mvcContext = $mvcContext;
        $this->uri = $uri;
        $this->serverInfo = $serverInfo;
        $this->router = $router;
        $this->dependencies[MvcContextInterface::class] = get_class($mvcContext);
        $this->resolveDependencies[get_class($mvcContext)] =$mvcContext;

    }

    public function registerDependency(string $abstraction, string $implementation ){


        $this->dependencies[$abstraction] = $implementation;


    }
    public function addBean(string $className , $object){
        $this->registerDependency($className,get_class($object));
        $this->resolveDependencies[$className] = $object;
    }

    public function start(){
        $fullControllerName = 'Controller\\' . ucfirst($this->mvcContext->getControllerName()) . 'Controller';

        if (!class_exists($fullControllerName)) {
            header("Location: /users/login");
            exit;
        }


        if (!method_exists($fullControllerName, $this->mvcContext->getActionName())) {

            header("Location: /users/login");
            exit;
        }
        $params = $this->mvcContext->getParams();

        foreach ($params as $param) {
            if (!method_exists($fullControllerName, $param)) {
                header("Location: /users/login");
                exit;
            }
        }


        $controllerInstance = $this->resolve($fullControllerName);
        $getParams = $this->mvcContext->getParams();
        $paramCount = count($getParams);
        $methodParams = array_merge([],$getParams);
        $methodInfo = new \ReflectionMethod($controllerInstance,$this->mvcContext->getActionName());
        $paramsInfo = $methodInfo->getParameters();

        for ($i = $paramCount ; $i < count($paramsInfo); $i++){
            $param = $paramsInfo[$i];
            $paramInterface = $param->getClass();
            $paramInterfaceName = $paramInterface->getName();

            if (key_exists($paramInterfaceName,$this->dependencies)){
                $paramClassName = $this->dependencies[$paramInterfaceName];
                $paramInstance = $this->resolve($paramClassName);

                $methodParams[] = $paramInstance;

            }else{
                $obj = new $paramInterfaceName();
                $this->bindData($_POST,$obj);
                $methodParams[] = $obj;

            }


        }
        call_user_func_array([$controllerInstance,$this->mvcContext->getActionName()],$methodParams);
    }


    public function resolve($className){
        if (key_exists($className, $this->resolveDependencies)){
            return $this->resolveDependencies[$className];
        }

        $classInfo = new \ReflectionClass($className);
        $ctor = $classInfo->getConstructor();
        if ($ctor === null){
            $obj = new $className;
            $this->resolveDependencies[$className] = $obj;

            return $obj;
        }

        $ctorParams = $ctor->getParameters();

        $resolveParams = [];

        for ($i = 0; $i < count($ctorParams); $i++){
            $parameter = $ctorParams[$i];
            $dependencyInterface = $parameter->getClass();
            if (key_exists($dependencyInterface->getName(),$this->resolveDependencies)){
                $resolveParams[] =$this->resolveDependencies[$dependencyInterface->getName()];
            }
            else{
                $dependencyClass = $this->dependencies[$dependencyInterface->getName()];
                $dependencyInstance = $this->resolve($dependencyClass);
                $resolveParams[] =$dependencyInstance;
            }

        }
        $obj = $classInfo->newInstanceArgs($resolveParams);
        $this->resolveDependencies[$className] = $obj;
        return  $obj;

    }

    private function bindData(array $data, $object ){
        $classInfo = new \ReflectionClass($object);

        $fields = $classInfo->getProperties();

        foreach ($fields as $field){
            $field->setAccessible(true);
            if (key_exists($field->getName(),$data)){
                $field->setValue($object, $data[$field->getName()]);
            }
        }
    }

}