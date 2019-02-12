<?php

##################################################################
#   Program:        OpenCanvas Interactive Website Design        #
#   Author:         Luis Gustavo Rodriguez (drlouie)             #
#   Copyright:      (c) 2009 Luis G. Rodriguez                   #
#   Licensing:      MIT License                                  #
#                                                                #
#   About                                                        #
#        Type:      User Interface Design and User Experience    #
#        Module:    Advanced Website Design Package              #
#        Info:   	Drag and drop website template selection,    #
#                   notes, sharing, and many other features as   #
#                   part of a sales tool to sell customized web  #
#                   design and development solutions.            #
#                                                                #
##################################################################################
# Permission is hereby granted, free of charge, to any person obtaining a copy   #
# of this software and associated documentation files (the "Software"), to deal  #
# in the Software without restriction, including without limitation the rights   #
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell      #
# copies of the Software, and to permit persons to whom the Software is          #
# furnished to do so, subject to the following conditions:                       #
#                                                                                #
# The above copyright notice and this permission notice shall be included in all #
# copies or substantial portions of the Software.                                #
#                                                                                #
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR     #
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,       #
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE    #
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER         #
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,  #
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE  #
# SOFTWARE.                                                                      #
##################################################################################

#-- vps-net.com > Professional Website Design Packages > Express Website Package [ OCX ]

	$phpCompileOS = $_SERVER["SERVER_SOFTWARE"];
	if (stristr($phpCompileOS, 'WIN') !== FALSE) {
		$HTTPRoot = 'H:/dvwf/rbsd_IO/vhosts/vsnet/htdocsNEW/';
	}
	else { $HTTPRoot = '/var/www/vps-net.com/htdocs/'; }

	// option 0 + suboption 0 = 0 home
	// option 1 + suboption 0 = section home
	// option 1 + suboption 1 = section document

	$section = 1;
	$subsection = 3;
	$canvasCall = 1;

	/** load INTERFACING[DOC-HEAD DOC-FOOT MAIN-MENUS MAIN-FUNCTIONS] */
	require_once($HTTPRoot.'opencanvas-interactive-website-design/index.php' );

?>

</body>
</html>