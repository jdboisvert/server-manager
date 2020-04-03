<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Used to encapsulate a model of a server connection 
 * which is entered and managed by a user. 
 */ 
class ServerConnection extends Model
{
    
    protected $table = 'server_connections';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'connection_name', 
        'connection_method', 
        'hostname', 
        'port', 
        'username',
        'password'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
    
    
    /**
     * Get the user that owns the server connection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
