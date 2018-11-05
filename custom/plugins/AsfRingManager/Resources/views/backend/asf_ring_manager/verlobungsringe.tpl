{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
    <form action="{url controller=AsfRingManager action=saveAndUpdateVerlobungsringe}" method="post">
        {assign var="globalNames" value=','|explode:"Gold,Palladium,Platin,Diamant,je Fassung,Zirkonia,333er Gold,585er Gold,750er Gold,585er Palladium,950er Palladium,600er Platin,950er Platin,Gelbweiß,Rotweiß,Tricolor,Gelb,Rot,Rosé,Weiß,Palladium,Platin,Gold,Palladium,Platin,Steinbesatz"}
        {assign var="globalHeadlines" value=','|explode:"Börsenpreise,Steinbesatz,Bearbeitungsgebühren,Aufschläge,Kalkulationsfaktoren"}
        {assign var="alloyHeadlines" value=','|explode:"Gold,Palladium,Platin"}
        <div class="row price_manager">
            <div class="col-lg-12">
                <div class="col-lg-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">Brillant / Princess</div>
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <fieldset>
                                        <legend>Brillant</legend>
                                        <div class="input-group">
                                            <ul class="list-inline">
                                                <li class="list-inline-item" style="font-size:14px; margin-right:63px;"><b>Karat</b></li>
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>G/SI</b></li>
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>G/VS</b></li>
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>E/IF</b></li>
                                            </ul>
                                        </div>
                                        {foreach from=$brillant key=key item=entries}
                                            <div class="input-group">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item" style="min-width: 100px">bis {$entries.carat}</li>
                                                    {foreach from=$entries key=subkey item=entry}
                                                        {if $entry@first}
                                                            {continue}
                                                        {/if}
                                                        {assign var="calcCarat" value=$entries.carat|replace:",":"."}
                                                        <input title="{((((($calcCarat * $entry) + 5) * 2.2) / 5)|ceil) * 5} €" type="text" name="PriceManager[entries][brillant_{$entries.carat}_{$subkey}]" value="{$entry}" style="width:60px"/>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        {/foreach}
                                    </fieldset>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="PriceManager[price_manager_action]" value="saveAndUpdateVerlobungsringe" class="btn btn-primary">Speichern & Aktualisieren</button>
                                    <button type="submit" name="PriceManager[price_manager_action]" value="synch" class="btn btn-primary">Synchronisieren</button>
                                    <br><br><br>
                                    {if $msg}
                                        <h3><span class="label label-success">{$msg}</span></h3>
                                    {/if}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <fieldset>
                                        <legend>Princess</legend>
                                        <div class="input-group">
                                            <ul class="list-inline">
                                                <li class="list-inline-item" style="font-size:14px; margin-right:63px;"><b>Karat</b></li>
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>G/SI</b></li>
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>G/VS</b></li>
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>E/IF</b></li>
                                            </ul>
                                        </div>
                                        {foreach from=$princess key=key item=entries}
                                            <div class="input-group">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item" style="min-width: 100px">bis {$entries.carat}</li>
                                                    {foreach from=$entries key=subkey item=entry}
                                                        {if $entry@first}
                                                            {continue}
                                                        {/if}
                                                        {assign var="calcCarat" value=$entries.carat|replace:",":"."}
                                                        <input title="{((((($calcCarat * $entry) + 5) * 2.2) / 5)|ceil) * 5} €" type="text" name="PriceManager[entries][princess_{$entries.carat}_{$subkey}]" value="{$entry}" style="width:60px"/>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        {/foreach}
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading">Globale Einstellung</div>
                        <div class="panel-body">

                            {assign var="counter" value=0}
                            {foreach from=$globals key=key item=global name="globals"}
                            {if $global@last || $global@iteration == 27}
                            {if $global@last || $global@iteration == 27}
                            {if $global@iteration == 27}
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Ring Anzahl in {$catName}</label>
                            <select class="form-control" name="PriceManager[globals][ring_quantity]">
                                <option {if $global.value == 1}selected{/if}>1</option>
                                <option {if $global.value == 2}selected{/if}>2</option>
                            </select>
                        </div>
                        {else}
                        <input type="hidden" name="PriceManager[cat]" value="{$global.value}">
                        <div class="form-group">
                            <button type="submit" name="PriceManager[price_manager_action]" value="saveAndUpdateVerlobungsringe" class="btn btn-primary">Speichern & Aktualisieren</button>
                        </div>
                    </div>
                    {/if}
                    {/if}
                    {else}
                    {if $global@iteration == 1 || $global@iteration == 4 || $global@iteration == 7 || $global@iteration == 14 || $global@iteration == 23}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <fieldset>
                                <legend>{$globalHeadlines.$counter}</legend>
                                {$counter = $counter + 1}
                                {/if}
                                <div class="input-group">
                                    <span class="input-group-addon" style="min-width:126px;float:left;">{$globalNames.$key}</span>
                                    <input type="text" value="{$global.value|replace:".":","}" name="PriceManager[globals][{$global.name}]" style="max-width:60px">
                                </div>
                                {if $global@iteration == 3 || $global@iteration == 6 || $global@iteration == 13 || $global@iteration == 22}
                            </fieldset>
                        </div>
                    </div>
                    {/if}
                    {/if}
                    {/foreach}
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
{/block}

{block name="content/javascript" append}

{/block}