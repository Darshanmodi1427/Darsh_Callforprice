# magento2-call-for-price

<h2> Mannual Installation Instructions</h2>
go to Magento2Project root dir 
create following Directory Structure :<br/>
<strong>/Magento2Project/app/code/Darsh/Callforprice</strong>
you can also create by following command:
<pre>
cd /Magento2Project
mkdir app/code/Darsh
mkdir app/code/Darsh/Callforprice
</pre>



<h3> Enable Darsh/Callforprice Module</h3>
to Enable this module you need to follow these steps:

<ul>
<li>
<strong>Enable the Module</strong>
<pre>bin/magento module:enable Darsh_Callforprice</pre></li>
<li>
<strong>Run Upgrade Setup</strong>
<pre>bin/magento setup:upgrade</pre></li>
<li>
<strong>Run static content deploy command</strong>
	<pre>bin/magento setup:static-content:deploy -f</pre>
</li>
</ul>


