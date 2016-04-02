<?php
/**
 * email footer
 */
if ( ! defined( 'ABSPATH' ) ) exit; 

$template_footer = "
	border-top:0;
	-webkit-border-radius:6px;
";

$credit = "
	border:0;
	color: #afafaf;
	font-family: Arial;
	font-size:12px;
	line-height:125%;
	text-align:center;
";
?>


				</div>
			</td>
        </tr>
    </table>
    <!-- End Content -->
            </td>
        </tr>
    </table>
    <!-- End Body -->
        </td>
    </tr>
	<tr>
    	<td align="center" valign="top">
            <!-- Footer -->
        	<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="<?php echo esc_attr__( $template_footer ); ?>">
            	<tr>
                	<td valign="top">
                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="2" valign="middle" id="credit" style="<?php echo esc_attr__( $credit ); ?>">
                                	<?php printf( esc_html__( '&copy;Copyright SocialBet %s', 'socialbet' ), date( 'Y' ) ); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- End Footer -->
        </td>
    </tr>
            </table>
        </td>
    </tr>
</table>
        </div>
    </body>
</html>