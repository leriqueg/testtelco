<?php

    public function getWSFollowing(string $username){
        $urlWSPOST = 'https://api.site.local/{$username}/following';
        $response = file_get_contents($urlWSPOST);
        $data = json_decode($response, true);
        if ($data == null)
            throw new \Exception('Error WS');
    }

public function buscarDistancia($usuarioX, $usuarioY){

        // se obtiene la data desde el API
//        $userAJson = getWSFollowing('userA');
//        $userBJson = getWSFollowing('userB');
//        $userCJson = getWSFollowing('userC');
        // datos de ejemplo

        $userAJson = ['Following'=>['userB','userD','userE','userG']];
        $userBJson = ['Following'=>['userC','userJ','userI','userE']];
        $userCJson = ['Following'=>['userM','userJ','userI','userE']];

        $userFollowingData = [
            'userA'=> $userAJson['Following'],
            'userB'=> $userBJson['Following'],
            'userC'=> $userCJson['Following'],
        ];

        $niveles = $this->buscarDistanciaArrayP($userFollowingData,$usuarioX,$usuarioY);
        echo $niveles;
        exit();
    }

    public function buscarDistanciaArrayP($data, $usuarioX, $usuarioY)
    {
        if (!array_key_exists($usuarioX, $data)) {
            print_r("no existe '{$usuarioX}' en la base de datos, se detiene la busqueda <br>");
            return 0;
        }

        $userFollowing = $data[$usuarioX];

        if (in_array($usuarioY, $userFollowing)) {
            print_r("El usuario '{$usuarioY}' existe en los seguidores de {$usuarioX} , finalizar la busqueda<br>");
            return 1;
        }

        foreach ($userFollowing as $followingUser ) {
            print_r("Buscando '{$usuarioY}' en los seguidores de {$followingUser} <br>");
            $found = $this->buscarDistanciaArrayP($data, $followingUser, $usuarioY);
            if ($found>0)
                return $found+1;
        }
        return $found;
    }
