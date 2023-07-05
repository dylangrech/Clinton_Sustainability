[{include file="headitem.tpl" title="sustainability_main_TITLE"|oxmultilangassign}]

<script type="text/javascript">
    function ShowMenueFields( iVal)
    {
        if( iVal == 2) {
            document.getElementById('cattree').style.visibility = 'visible';
        } else {
            document.getElementById('cattree').style.visibility = 'hidden';
        }

        if( iVal == 3) {
            document.getElementById('manuell').style.visibility = 'visible';
        } else {
            document.getElementById('manuell').style.visibility = 'hidden';
        }
    }
</script>

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="sustainability_main">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>
<form id="submitSustainabilityForm" name="myedit" id="myedit" enctype="multipart/form-data" action="[{$oViewConf->getSelfLink()}]" method="post" onSubmit="copyLongDesc( 'clinton_sustainability__oxcontent' );">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="sustainability_main">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[clinton_sustainability__oxid]" value="[{$oxid}]">
    <input type="hidden" name="folderclass" value="">

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <colgroup>
            <col width="30%">
            <col width="5%">
            <col width="65%">
        </colgroup>
        <tr>
            <td valign="top" width="200">
                <table cellspacing="0" cellpadding="0" border="0">
                    [{block name="admin_sustainability_main_form"}]
                    <tr>
                        <td class="edittext" width="70">
                            [{oxmultilang ident="GENERAL_ACTIVE"}]
                        </td>
                        <td class="edittext">
                            <input class="edittext" type="checkbox" name="editval[clinton_sustainability__oxactive]" value='1' [{if $edit->clinton_sustainability__oxactive->value == 1}]checked[{/if}] [{$readonly}] [{$disableSharedEdit}]>
                        </td>
                    </tr>

                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="CLINTON_SUSTAINABILITY_TITLE"}]
                        </td>
                        <td class="edittext">
                            <input id="fcSustainabilityTitle" type="text" class="editinput" size="28" name="editval[clinton_sustainability__clititle]" value="[{$edit->clinton_sustainability__clititle->value}]">
                        </td>
                    </tr>

                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="CLINTON_SUSTAINABILITY_IMAGE_UPLOAD"}]
                        </td>
                        <td class="edittext">
                            <input id="fileUpload" onchange="loadFile(event)" type="file" class="editinput" name="myfile[SUSTAINABILITY_IMAGE@clinton_sustainability__cliimg]" [{$readonly}]>
                        </td>
                    </tr>

                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="CLINTON_SUSTAINABILITY_IMAGE"}]
                        </td>
                        <td class="edittext">
                            <input id="fileNameInput" readonly type="text" class="editinput" size="28" name="editval[clinton_sustainability__cliimg]" value="[{$edit->clinton_sustainability__cliimg->value}]">
                        </td>
                    </tr>

                    <tr>
                        <td class="edittext">
                            [{oxmultilang ident="CLINTON_SUSTAINABILITY_LINK"}]
                        </td>
                        <td class="edittext">
                            <input type="text" class="editinput" size="28" name="editval[clinton_sustainability__clilink]" value="[{$edit->clinton_sustainability__clilink->value}]">
                        </td>
                    </tr>
                    [{/block}]
                    <tr>
                        <td class="edittext">
                        </td>
                        <td class="edittext">
                            <input id="saveSustainability" type="submit" class="edittext" name="saveSustainability" value="[{oxmultilang ident="GENERAL_SAVE"}]" onClick="Javascript:document.myedit.fnc.value='save'"" [{$readonly}]><br>
                        </td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
            <!-- Anfang rechte Seite -->
            <td valign="top" class="edittext" align="left">
                [{block name="admin_sustainability_main_editor"}]
                <h3>[{oxmultilang ident="CLINTON_SUSTAINABILITY_IMAGE_PREVIEW"}]</h3>
                [{if !is_null($edit->clinton_sustainability__cliimg->value) && ($edit->clinton_sustainability__cliimg->value !== '')}]
                    [{assign var="sUploadedLicenceImage" value=$edit->fcGetImageUrl()}]
                    <img src="[{$sUploadedLicenceImage}]" style="display: block; margin-left: auto; margin-right: auto;"  class="img-responsive" id="output"/>
                [{else}]
                    <img src="" style="display: block; margin-left: auto; margin-right: auto;"  class="img-responsive" id="output"/>
                [{/if}]
                [{/block}]
            </td>
            <!-- Ende rechte Seite -->
        </tr>
    </table>
</form>
<script>
    const loadFile = function (event) {
        let uploadedFile = document.getElementById('fileUpload');
        document.getElementById('fileNameInput').value = uploadedFile.files[0].name;
        let output = document.getElementById('output');
        output.removeAttribute('src');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('saveSustainability').onclick = function (event) {
            let inputtedSustainabilityTitle = document.getElementById('fcSustainabilityTitle').value;
            if (inputtedSustainabilityTitle === '') {
                event.preventDefault();
                alert('[{oxmultilang ident="CLINTON_SUSTAINABILITY_INSERT_TITLE"}]');
            }
            document.myedit.fnc.value='save'
        }
    });

</script>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
