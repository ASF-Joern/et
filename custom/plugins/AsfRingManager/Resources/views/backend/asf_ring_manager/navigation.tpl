<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{url controller=AsfAfterbuy action=index}">Übersicht</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li {if {controllerAction} === 'config'} class="active"{/if}><a href="{url controller=AsfAfterbuy action=config}">Konfiguration</a></li>
                <li {if {controllerAction} === 'price'} class="active"{/if}><a href="{url controller=AsfAfterbuy action=priceManager}">Preis Kalkulation</a></li>
                <li {if {controllerAction} === 'crons'} class="active"{/if}><a href="{url controller=AsfAfterbuy action=crons}">Cronjobs</a></li>
                <li {if {controllerAction} === 'functions'} class="active"{/if}><a href="{url controller=AsfAfterbuy action=functions}">Funktionsaufruf</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>