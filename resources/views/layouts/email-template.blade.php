<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width: 100% !important; -webkit-text-size-adjust: none; background-color: #FAFAFA; margin: 0; padding: 0;" bgcolor="#FAFAFA">
  <style type="text/css">
	.preheaderContent div a:visited { color: #336699 !important; font-weight: normal !important; text-decoration: underline !important; }
	.headerContent a:visited { color: #336699 !important; font-weight: normal !important; text-decoration: underline !important; }
	.bodyContent div a:visited { color: #336699 !important; font-weight: normal !important; text-decoration: underline !important; }
	.footerContent div a:visited { color: #336699 !important; font-weight: normal !important; text-decoration: underline !important; }
</style>	
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="600" id="backgroundTable" style="background-color: #FAFAFA; margin: 0; padding: 0;" bgcolor="#FAFAFA">
	        	<tr>
	        		<td align="center" valign="top" style="border-collapse: collapse;">
                        <!-- // Begin Template Preheader \\ -->
                        <table border="0" cellpadding="10" cellspacing="0" width="100%" id="templatePreheader" style="background-color: #FAFAFA;" bgcolor="#FAFAFA">
							<tr>
                      	  		<td valign="top" class="preheaderContent" style="border-collapse: collapse;">
   			             	<!-- // Begin Module: Standard Preheader \ -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%"><tr><td valign="top" style="border-collapse: collapse;">
                                            	<div style="color: #505050; font-family: Arial; font-size: 10px; line-height: 100%; text-align: left;" align="left">
                                                	&nbsp;
                                                </div>
                                            </td>
                                            <!-- *|IFNOT:ARCHIVE_PAGE|* -->
											<td valign="top" width="190" style="border-collapse: collapse;">
                                            	<div style="color: #505050; font-family: Arial; font-size: 10px; line-height: 100%; text-align: left;" align="left">
                                                	Is this email not displaying correctly?
                                                	<br />
                                                	<a href="#" target="_blank" style="color: #336699; font-weight: normal; text-decoration: underline;">
                                                		View it in your browser
                                                	</a>.
                                                </div>
                                            </td>
											<!-- *|END:IF|* -->
                                        </tr>
                                    </table>
                                    <!-- // End Module: Standard Preheader \ -->
								</td>
							</tr>
                        </table><!-- // End Template Preheader \\ -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainer" style="background-color: #FFFFFF; border: 1px solid #dddddd;" bgcolor="#FFFFFF">
                        	<tr>
		                        <td align="center" valign="top" style="border-collapse: collapse;">
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader" style="background-color: #FFFFFF; border-bottom-width: 0;" bgcolor="#FFFFFF">
                                		<tr>
                                			<td class="headerContent" style="border-collapse: collapse; color: #fff; font-family: Arial; font-size: 34px; font-weight: bold; line-height: 100%; text-align: center; vertical-align: middle; padding: 0;" align="center" valign="middle">
                                            	<!-- // Begin Module: Standard Header Image \\ -->    
                                            	<img src=" {{ asset(App\Option::slug('email-image')->image->path) }}" style="margin: auto; height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0;" id="headerImage campaign-icon" /><!-- // End Module: Standard Header Image \\ --></td>

                                        </tr>
                                    </table><!-- // End Template Header \\ -->
                                </td>
                            </tr>
                            <tr>
                            	<td align="center" valign="top" style="border-collapse: collapse;">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="temsamplateBody">
                                		<tr>
                                			<td valign="top" class="bodyContent" style="border-collapse: collapse; background-color: #FFFFFF;" bgcolor="#FFFFFF">
                                                <!-- // Begin Module: Standard Content \\ -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
	                                                <tr>
	                                               		<td valign="top" style="border-collapse: collapse;">

                                                            <div style="color: #505050; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;" align="left">
                                                           
																  @yield('content')               
															</div>
														</td>
                                                    </tr>
                                                </table><!-- // End Module: Standard Content \\ -->
                                            </td>
                                        </tr>
                                    </table><!-- // End Template Body \\ -->
                                </td>
                            </tr>
                            <tr>
                            	<td align="center" valign="top" style="border-collapse: collapse;">
                                    <!-- // Begin Template Footer \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="100%" id="templateFooter" style="background-color: #FFFFFF; border-top-width: 0;" bgcolor="#FFFFFF">
                                		<tr>
                                			<td valign="top" class="footerContent" style="border-collapse: collapse;">  
                                                <!-- // Begin Module: Standard Footer \\ -->
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                    	<td valign="top" width="350" style="border-collapse: collapse;">
                                                            <div style="color: #707070; font-family: Arial; font-size: 12px; line-height: 125%; text-align: left;" align="left">
																<em>Copyright &copy; <?php echo date("Y"); ?>, All rights reserved.</em>
																<br />
															</div>
                                                        </td>
                                                        <td valign="top" width="190" id="monkeyRewards" style="border-collapse: collapse;">
                                                            <div style="color: #707070; font-family: Arial; font-size: 12px; line-height: 125%; text-align: left;" align="left">
                                                                <?php /* ?>
                                                                <strong>Our mailing address is:</strong>
																<br />
																no-reply@domain.com
                                                                <?php */ ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table><!-- // End Module: Standard Footer \\ -->
                                            </td>
                                        </tr>
                                    </table><!-- // End Template Footer \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
