<input id="fcSustainabilityButton" [{$readonly}] type="button" value="[{oxmultilang ident="CLINTON_SUSTAINABILITY_MAIN_ASSIGN"}]" class="edittext" onclick="JavaScript:showDialog('&cl=article_extend&aoc=3&oxid=[{$oxid}]');">
<script>
    let fcSustainabilityButton = document.getElementById('fcSustainabilityButton');
    let parentElement = fcSustainabilityButton.parentElement.parentElement;
    let siblingElement = parentElement.children[0];
    if (fcSustainabilityButton) {
        siblingElement.insertAdjacentElement("afterend", fcSustainabilityButton);
    }
</script>
[{$smarty.block.parent}]