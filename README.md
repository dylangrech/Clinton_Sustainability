<h1>Installation Guide for the Clinton Sustainability Module</h1>
<h3>Manual Installation</h3>
<ol>
    <li>Download a version from Github(unless you already have the zip folder ready to go)</li>
    <li>Create the folder "fc" in the "source/modules" folder in the Oxid EShop of your choice. If the folder "fc" is already there you may skip this step</li>
    <li>Create the folder "clisustainability" in the "source/modules/fc" folder in the Oxid EShop of your choice.</li>
    <li>Copy the content of the downloaded zip file in the newly created "clisustainability" folder.</li>
    <li>In OXID versions from 6.2 on (older versions can skip this step) you must now import the module configuration. To do this, log in via SSH to the server on which the shop installation is located and navigate to the directory in which the source and vendor folders are located. Execute the following commands:</li>
    <code>vendor/bin/oe-console oe:module:install-configuration source/modules/fc/clisustainability</code><br>
    <code>composer config repositories.fc/clisustainability path source/modules/fc/clisustainability</code><br>
    <code>composer require fc/cli-sustainability -n</code>
</ol>
<p>Module is not fully installed. Go to the backend and activate the Module! If there are any questions please do not hesitate to contact us</p>
