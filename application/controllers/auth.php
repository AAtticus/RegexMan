<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function session($provider)
    {

        if($provider == 'facebook')
        {
            $settings = array(
            'id' => 'YOUR_FACEBOOK_APP_ID',
            'secret' => 'YOUR_FACEBOOK_APP_SECRET',
            );
        }

        if($provider == 'google')
        {
            $settings = array(
            'id' => 'YOUR_GOOGLE_APP_ID',
            'secret' => 'YOUR_GOOGLE_APP_SECRET',
            );
        }

        $provider = $this->oauth2->provider($provider, $settings);

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                $GameUser = new User();

                $GameUser->where('uid', $user['uid'])->get();

                if ( ! is_numeric($GameUser->id))
                {
                    $GameUser->first_name    = $user['first_name'];
                    $GameUser->last_name     = $user['last_name'];
                    $GameUser->email         = $user['email'];
                    $GameUser->image         = $user['image'];
                    $GameUser->uid           = $user['uid'];
                    
                    try
                    {
                        $GameUser->save();

                    }
                    catch(Exception $e)
                    {
                        show_error('Couldnt save new Game User from this OAuth Source: ' .$e);
                    }

                }
               
                $this->session->set_userdata('GameUserId', $GameUser->id);
                redirect('/profile');
            }

            catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }

        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}

?>