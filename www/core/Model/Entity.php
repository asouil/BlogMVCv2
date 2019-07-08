<?php
namespace Core\Model;

class Entity
{
    public function hydrate(array $data): void {
        foreach($data as $key => $value) {
            $methode = 'set'.ucfirst($key);
            if(method_exists($this, $methode)) {
                $this->$methode(htmlspecialchars($value));
            }
        }
    }
    public function objectToArray ($object) {
        if(!is_object($object) && !is_array($object))
            return $object;
    
        return array_map('objectToArray', (array) $object);
    }
}
