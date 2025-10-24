<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class satusehat extends Model
{
    // public $baseUrl = 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/';
    public $Auth = 'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1';
    public $baseUrl = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1';
    public $basemaster = 'https://api-satusehat-stg.kemkes.go.id';
    public function get_token()
    {
        $AUTH = 'https://api-satusehat-dev.dto.kemkes.go.id/oauth2/v1/accesstoken?grant_type=client_credentials';
        $client = new Client();
        $data = [
            'client_id' => 'cVT5QJgMHFhLhbTBlPiPNg0QdAlTuBK51qWaNb76gYBpH1tQ',
            'client_secret' => '9g2GPDVFN9sZvnb2IPaIuqHsqsI13mVjQIkj08szA2xiqALDuerE2OvcviKsbF7F'
        ];
        $response = $client->request('POST', $AUTH, [
            'form_params' => $data,
            'allow_redirects' => true,
            'timeout' => 20
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function signature()
    {
        $get_token = $this->get_token();
        $response = array(
            'authorization' => 'Bearer ' . $get_token->access_token,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Connection' => 'keep-alive'
        );
        return $response;
    }
    public function get_prov($no)
    {
        $client = new Client();
        $url = $this->basemaster."/masterdata/v2/provinces?current_page=".$no."&next=&prev=";
        $get_token = $this->get_token();
        $header = array(
            'authorization' => 'Bearer ' . $get_token->access_token,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Connection' => 'keep-alive'
        );
        $response = $client->request('GET', $url, [
            'headers' => $header,
            'allow_redirects' => true,
            'timeout' => 5
        ]);
        $response = json_decode($response->getBody());
        return $response;

    }
    public function get_kab($no)
    {
        $client = new Client();
        $url = $this->basemaster."/masterdata/v1/cities?province_codes=".$no;
        $get_token = $this->get_token();
        $header = array(
            'authorization' => 'Bearer ' . $get_token->access_token,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Connection' => 'keep-alive'
        );
        $response = $client->request('GET', $url, [
            'headers' => $header,
            'allow_redirects' => true,
            'timeout' => 5
        ]);
        $response = json_decode($response->getBody());
        return $response;

    }
    public function get_kec($no)
    {
        $client = new Client();
        $url = $this->basemaster."/masterdata/v1/districts?city_codes=".$no;
        $get_token = $this->get_token();
        $header = array(
            'authorization' => 'Bearer ' . $get_token->access_token,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Connection' => 'keep-alive'
        );
        $response = $client->request('GET', $url, [
            'headers' => $header,
            'allow_redirects' => true,
            'timeout' => 5
        ]);
        $response = json_decode($response->getBody());
        return $response;

    }
    public function get_desa($no)
    {
        $client = new Client();
        $url = $this->basemaster."/masterdata/v1/sub-districts?district_codes=".$no;
        $get_token = $this->get_token();
        $header = array(
            'authorization' => 'Bearer ' . $get_token->access_token,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Connection' => 'keep-alive'
        );
        $response = $client->request('GET', $url, [
            'headers' => $header,
            'allow_redirects' => true,
            'timeout' => 5
        ]);
        $response = json_decode($response->getBody());
        return $response;

    }
    public function patient_search_nik($nik)
    {
        $client = new Client();
        $signature = $this->signature();
        $url = $this->baseUrl . "/Patient?identifier=https://fhir.kemkes.go.id/id/nik|" . $nik;
        // $token = $this->signature();    
        try {
            $response = $client->request('GET', $url, [
                'headers' => $signature,
                'allow_redirects' => true,
                'timeout' => 10
            ]);
            $code = $response->getStatusCode();
            if ($code == 200) {
                $response1 = json_decode($response->getBody());
                $jumlah = $response1->total;
                if ($jumlah > 0) {
                    $idpasien = $response1->entry[0]->resource->id;
                } else {
                    $idpasien = 0;
                }
            } else {
                $idpasien = 0;
            }
            $response = [
                'idpasien' => $idpasien,
                'status' => 'OK'
            ];
            return $response;
        } catch (\Exception $e) {
            $response = [
                'idpasien' => 'OK',
                'status' => 'ERROR'
            ];
            return $response;
        }
    }
}
