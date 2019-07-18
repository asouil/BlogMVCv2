<?php
namespace Core\Controller;

class FormController
{

    private $postDatas;

    private $fields = [];

    private $errors = [];

    private $datas = [];

    private $isVerify = false;

    public function __construct()
    {
        if (count($_POST) > 0) {
            //Storage form's datas in $this->postDatas
            $this->postDatas = $_POST;
        } else {
            $this->addError("post", "no-data");
        }
    }

    public function field(string $field, array $constraints = []): self
    {    
        // Commentaire se déroule durant l'inscription
        /*  $field = 'mail';
            $constraints[1 => 'require',
                    2 => 'verify'] */
        foreach ($constraints as $key => $value) {
            if (!is_string($key)) {
                //Comments in first lap Start
                //$constraints['require'] = true;
                $constraints[$value] = true;
                /*constraints[1 => 'require',
                              2 => 'verify',
                              'require' => true]; */

                //unset($constraints[1]);
                unset($constraints[$key]);
                //Lap One Over
            }
        }

        //$this->fields['mail'] = $constraints;
        $this->fields[$field] =  $constraints;

        //On retourne l'instance afin de pouvoir appeler plusieurs méthodes à la suite
        return $this;
    }
    

    public function hasErrors(): array
    {
        $this->verifyErrors();
        return $this->errors;
    }

    public function getDatas(): array
    {
        $this->verifyErrors();
        return $this->datas;
    }

    private function verifyErrors(): void
    {
        if (!$this->isVerify) {
            /*
            Content of $this->field at the subscription moment
            $this->fields = ['mail' => ['require' => true,
                                        'verify' => true]
                            'password'  => ['require' => true,
                                            'verify' => true,
                                            'length' => 8]
                            ] */
            foreach ($this->fields as $field => $constraints) {
                // In first lap
                // $field = 'mail';
                /* $constraints = ['require' => true,
                                    'verify' => true] */
                if (count($constraints) <= 0) {
                    //$this->addDatas('mail');
                    $this->addData($field);
                }
                foreach ($constraints as $constraint => $value) {
                    //$constraintMethod = errorRequire
                    $constraintMethod = 'error'.ucfirst(strtolower($constraint));
                    if (method_exists($this, $constraintMethod)) {
                        //$this->errorRequire($field, $value)
                        $this->$constraintMethod($field, $value);
                    } else {
                        throw new \Exception("la contrainte {$constraint} n'existe pas");
                    }
                }
            }
            $this->isVerify = true;
        }
    }

    private function errorRequire(string $field, bool $value = false): void
    {
        /* $field= 'mail'
            $bool = true */
        if (!empty($this->postDatas[$field])) {
            $this->addData($field);
        } else {
            $this->addError($field, "le champ {$field} est requis");
        }
    }

    private function errorVerify(string $field, bool $value = false): void
    {
        if (isset($this->postDatas[$field."Verify"])) {
            if ($this->postDatas[$field."Verify"] == $this->postDatas[$field]) {
                $this->addData($field);
            } else {
                $this->addError($field, "les champs {$field} doivent correspondre");
            }
        }
    }

    private function errorLength(string $field, $value = false): void
    {
        if (strlen($this->postDatas[$field]) >= $value) {
            $this->addData($field);
        } else {
            $this->addError($field, "le champ {$field} doit avoir au minimum {$value} caractères");
        }
    }




    private function addData(string $field): void
    {
        //$field = 'mail';
        if (!isset($this->errors[$field])) {
            $this->datas[$field] = htmlspecialchars($this->postDatas[$field]);
            //dd($this->datas);
        }
    }

    private function addError(string $field, string $message): void
    {   
        //$field = 'mail'
        //Delete $this->datas['mail'];
        unset($this->datas[$field]);
        
        $this->errors[$field][] = $message;
        /* $this->errors['mail'] = ['le champ 'mail est requis',
                                 'etc..
                                ]
                      ]*/
    }
}
