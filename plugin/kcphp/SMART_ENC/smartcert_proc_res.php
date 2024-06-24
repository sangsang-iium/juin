<?
    /* ============================================================================== */
    /* =   ���������� ���� �� ��ȣȭ ������                                         = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �ش� �������� �ݵ�� ������ ������ ���ε� �Ǿ�� �ϸ�                    = */ 
    /* =   ������ �������� ����Ͻñ� �ٶ��ϴ�.                                     = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   ���̺귯�� ���� Include                                                  = */
    /* = -------------------------------------------------------------------------- = */

    include "../cfg/cert_conf.php";
    require "../lib/ct_cli_lib.php";

    $ENC_KEY = "9eb2cc7e320e2d7d54bc4a92ec1e9dc1057f386f2435d42e9f9e051404b249f8";
    $home_dir = "[/plugin/kcphp/]";

    /* = -------------------------------------------------------------------------- = */
    /* =   ���̺귯�� ���� Include END                                               = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   null ���� ó���ϴ� �޼ҵ�                                                = */
    /* = -------------------------------------------------------------------------- = */
    function f_get_parm_str( $val )
    {
        if ( $val == null ) $val = "";
        if ( $val == ""   ) $val = "";
        return  $val;
    }
    /* ============================================================================== */
    $site_cd       = "";
    $ordr_idxx     = "";
    
    $cert_no       = "";
    $enc_info      = "";
    $enc_data      = "";
    $req_tx        = "";
    
    $enc_cert_data2 = "";
    $cert_info     = "";

    $tran_cd       = "";
    $res_cd        = "";
    $res_msg       = "";

    $dn_hash       = "";
	/*------------------------------------------------------------------------*/
    /*  :: ��ü �Ķ���� �����                                               */
    /*------------------------------------------------------------------------*/

    // request �� �Ѿ�� �� ó��
    foreach($_POST as $nmParam => $valParam)
    {

        if ( $nmParam == "site_cd" )
        {
            $site_cd = f_get_parm_str ( $valParam );
        }

        if ( $nmParam == "ordr_idxx" )
        {
            $ordr_idxx = f_get_parm_str ( $valParam );
        }

        if ( $nmParam == "res_cd" )
        {
            $res_cd = f_get_parm_str ( $valParam );
        }

        if ( $nmParam == "req_tx" )
        {
            $req_tx = f_get_parm_str ( $valParam );
        }

        if ( $nmParam == "cert_no" )
        {
            $cert_no = f_get_parm_str ( $valParam );
        }

        if ( $nmParam == "enc_cert_data2" )
        {
            $enc_cert_data2 = f_get_parm_str ( $valParam );
        }

        if ( $nmParam == "dn_hash" )
        {
            $dn_hash = f_get_parm_str ( $valParam );
       }

        // �θ�â���� �ѱ�� form ������ ���� �ʵ�
        $sbParam .= "<input type='hidden' name='" . $nmParam . "' value='" . f_get_parm_str( $valParam ) . "'/>";
    }
    

    $ct_cert = new C_CT_CLI;
    $ct_cert->mf_clear();

    // ��� ó��
        if( $res_cd == "0000" )
        {

            // dn_hash ����
            // KCP �� ������ �帮�� dn_hash �� ����Ʈ �ڵ�, ��û��ȣ , ������ȣ�� �����Ͽ�
            // �ش� �������� �������� �����մϴ�
             $veri_str = $site_cd.$ordr_idxx.$cert_no; // ����Ʈ �ڵ� + ��û��ȣ + �����ŷ���ȣ

            if ( $ct_cert->check_valid_hash ( $home_dir , $ENC_KEY, $dn_hash , $veri_str ) != "1" ) 
            {
                echo "dn_hash ���� ��������";
                // ���� ó�� ( dn_hash ���� ��������)
            }

            // ������ DB ó�� ������ ����
            echo "========================= ���� ������ ======================="       ."<br>";
            echo "����Ʈ �ڵ�            :" . $site_cd                                 ."<br>";
            echo "���� ��ȣ              :" . $cert_no                                 ."<br>";
            echo "��ȣ�� ��������        :" . $enc_cert_data2                          ."<br>";

            // ���������� ��ȣȭ �Լ�
            // �ش� �Լ��� ��ȣȭ�� enc_cert_data2 ��
            // site_cd �� cert_no �� ������ ��ȭȭ �ϴ� �Լ� �Դϴ�.
            // ���������� ��ȣȭ �Ȱ�쿡�� ���������͸� �����ü� �ֽ��ϴ�.                   
            $opt = "0" ; // ��ȣȭ ���ڵ� �ɼ� ( UTF - 8 ���� "1" ) 
            $ct_cert->decrypt_enc_cert( $home_dir, $ENC_KEY, $site_cd , $cert_no , $enc_cert_data2 , $opt );
            
            echo "========================= ��ȣȭ ������ ====================="       ."<br>";
            echo "��ȣȭ �̵���Ż� �ڵ� :" . $ct_cert->mf_get_key_value("comm_id"    )."<br>"; // �̵���Ż� �ڵ�   
            echo "��ȣȭ ��ȭ��ȣ        :" . $ct_cert->mf_get_key_value("phone_no"   )."<br>"; // ��ȭ��ȣ          
            echo "��ȣȭ �̸�            :" . $ct_cert->mf_get_key_value("user_name"  )."<br>"; // �̸�              
            echo "��ȣȭ �������        :" . $ct_cert->mf_get_key_value("birth_day"  )."<br>"; // �������          
            echo "��ȣȭ �����ڵ�        :" . $ct_cert->mf_get_key_value("sex_code"   )."<br>"; // �����ڵ�          
            echo "��ȣȭ ��/�ܱ��� ����  :" . $ct_cert->mf_get_key_value("local_code" )."<br>"; // ��/�ܱ��� ����    
            echo "��ȣȭ CI              :" . $ct_cert->mf_get_key_value("ci_url"     )."<br>"; // CI                
            echo "��ȣȭ DI              :" . $ct_cert->mf_get_key_value("di_url"     )."<br>"; // DI �ߺ����� Ȯ�ΰ�
            echo "��ȣȭ WEB_SITEID      :" . $ct_cert->mf_get_key_value("web_siteid" )."<br>"; // WEB_SITEID
            echo "��ȣȭ ����ڵ�        :" . $ct_cert->mf_get_key_value("res_cd"     )."<br>"; // ��ȣȭ�� ����ڵ�
            echo "��ȣȭ ����޽���      :" . $ct_cert->mf_get_key_value("res_msg"    )."<br>"; // ��ȣȭ�� ����޽���
			
        }
        else/*if( res_cd.equals( "0000" ) != true )*/
        {
           // ��������
        }
    

    $ct_cert->mf_clear();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=EUC-KR">
        <title>*** KCP Online Payment System [PHP Version] ***</title>
        <script type="text/javascript">
            window.onload=function()
            {
                try
                {
                    parent.auth_data( document.form_auth ); // �θ�â���� �� ����
                }
                catch(e)
                {
                    alert(e); // �������� �θ�â�� iframe �� ��ã�� �����
                }
            }
        </script>
    </head>
    <body oncontextmenu="return false;" ondragstart="return false;" onselectstart="return false;">
        <form name="form_auth" method="post">
            <?= $sbParam ?>
        </form>
    </body>
</html>
