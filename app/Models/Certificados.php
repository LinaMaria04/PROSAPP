<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    use HasFactory;

    protected $table = 'certificados';
    protected $primaryKey = 'ID_Cert';

    protected $fillable = [
        'CertType',
        'CertNumero',
        'CertiEspName',
        'CertiEspValue',
        'CertObservacion',
        'CertSlug',
        'CertNumRm',
        'CertSrc',
        'CertAuthHseq',
        'CertAuthJl',
        'CertAuthDp',
        'CertAnexo',
        'CertManifNumero',
        'CertNumeroExt',
        'CertManifPrepend',
        'CertSrcManif',
        'CertSrcExt',
        'FK_CertSolser',
        'FK_CertCliente',
        'FK_CertGenerSede',
        'FK_CertGestor',
        'FK_CertTrat',
        'FK_CertTransp',
        'created_at',
        'updated_at'
    ];
}