function sliceTime() {
    ///<summary>Converte a data rfc em um formato amigável para leitura</summary>
    /// <param name="timeRFC" type="String">a data em formato rfc</param>
    /// <param name="format" type="String">(Opcional, padrão é Full).O formato de retorno, utilize o list slice.list.time.format para obter a lista de formatos</param>
    //#region propriedades privadas
    this._timeRFC = '';
    this._format = slice.list.time.format.Full;
    this._containerId = null;
    this._containerList = new Array();
    this._containerIncrement = 1;
    this._timerMonitoreId = null;
    this._setContainerList = function (containerList) {
        this._containerList = containerList;
    };
    this._getContainerList = function () {
        return this._containerList;
    };
    this._setContainerIncrement = function (containerIncrement) {
        this._containerIncrement = containerIncrement;
    };
    this._getContainerIncrement = function () {
        return this._containerIncrement;
    };
    this._setTimerMonitoreId = function (timerMonitoreId) {
        this._timerMonitoreId = timerMonitoreId;
    };
    this._getTimerMonitoreId = function () {
        return this._timerMonitoreId;
    };
    this._getTimeRFC = function () {
        /// <summary>Retorna a data em formato RFC</summary>
        /// <returns type="String">A data em formato RFC</returns>
        return this._timeRFC;
    };
    this._getFormat = function () {
        /// <summary>Retorna o formato amigável a ser usado</summary>
        /// <returns type="String">O formato amigável</returns>
        return this._format;
    };
    this._setContainerId = function (id) {
        /// <summary>Define o id do container da data, usado apenas para auto atualização</summary>
        /// <param name="id" type="String">A id do objeto que contém ou deve conter a data, como span ou div</param>
        this._containerId = id;
    };
    this._getContainerId = function () {
        /// <summary>Retorna a id do container da data, usado apenas para auto atualização</summary>
        /// <returns type="String">A id do container</returns>
        return this._containerId;
    };
    this._monthToString = function (month, isShort) {
        /// <summary>Obtem o nome do mês</summary>
        /// <param name="month" type="Number">O número do mês 0-11</param>
        /// <param name="isShort" type="Boolean">Se verdadeiro, o nome do mês fica abreviado</param>
        /// <returns type="String">Retorna o mês em formato de texto</returns>
        var pt = new Array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        var s = pt[month];
        if (s) {
            s = (isShort ? s.substring(0, 3) : s);
        } else {
            s = '';
        }
        return s;
    };
    this._yearToString = function (year, isShort) {
        /// <summary>Obtem o ano</summary>
        /// <param name="year" type="Number">O ano em formato de quatro dígitos</param>
        /// <param name="isShort" type="Boolean">Se verdadeiro, o ano é reduzido para os últimos dois dígitos</param>
        var s = new String(year);
        s = isShort ? s.substring(2, 4) : s;
        return s;
    };
    this._leadingZero = function (number) {
        /// <summary>Garante ao menos dois dígitos, colocando um 0 �  esquerda</summary>
        /// <param name="number" type="Mixed">O número int ou string</param>
        /// <param name="short" type="String">Adiciona 0 �  esquerda se o número for menor que 10</param>
        return parseInt('' + number) < 10 ? '0' + number : '' + number;
    };
    this._getFullText = function () {
        /// <summary>A partir do tempoRFC fornecido, transforma em um formato amigável em texto completo</summary>
        /// <returns type="String">A data em formato completo</returns>
        var o = new Date(this._getTimeRFC());
        var c = new Date();
        var d = Math.round(c.getTime() / 1000) - Math.round(o.getTime() / 1000);
        var s = "";
        var s1 = "";
        //segundos
        /*if (d < 60) {
        s1 = d < 2 ? 'segundos' : d + ' segundos';
        return this._leadingZero(o.getHours()) + ':' + this._leadingZero(o.getMinutes()) + ' (' + s1 + ' atrás)';
        }*/
        //minutos
        if (d < (60 * 60)) {

            if (Math.round(d / 60) < 2) {
                var t = Math.round(d / 60);
                s1 = t > 0 ? t + " minuto" : 'segundos';
            } else {
                s1 = Math.round(d / 60) + " minutos";
            }
            return this._leadingZero(o.getHours()) + ':' + this._leadingZero(o.getMinutes()) + ' (' + s1 + ' atrás)';
        }
        //horas
        if (d < (60 * 60 * 24)) {
            if (Math.round(d / (60 * 60)) < 2) {
                s1 = Math.round(d / (60 * 60)) + " hora";
            } else {
                s1 = Math.round(d / (60 * 60)) + " horas";
            }

            return (o.getDate() != c.getDate() ? this._leadingZero(o.getDate()) + ' ' + this._monthToString(o.getMonth(), true) + ' ' : '') + this._leadingZero(o.getHours()) + ':' + this._leadingZero(o.getMinutes()) + ' (' + s1 + ' atrás)';
        }
        //dias
        if (d < (60 * 60 * 24 * 7)) {
            switch (Math.round(d / (60 * 60 * 24))) {
                case 1:
                    s1 = "Ontem";
                    break;
                case 2:
                    s1 = "Anteontem";
                    break;
                default:
                    s1 = Math.round(d / (60 * 60 * 24)) + " dias atrás";
                    break;
            }
            return this._leadingZero(o.getDate()) + ' ' + this._monthToString(o.getMonth(), true) + ' ' + this._leadingZero(o.getHours()) + ':' + this._leadingZero(o.getMinutes()) + ' (' + s1 + ')';
        }
        //semanas
        if (d < (60 * 60 * 24 * 7 * 4)) {
            if (Math.round(d / (60 * 60 * 24 * 7)) < 2) {
                s1 = Math.round(d / (60 * 60 * 24 * 7)) + " semana atrás";
            } else {
                s1 = Math.round(d / (60 * 60 * 24 * 7)) + " semanas atrás";
            }

            return this._leadingZero(o.getDate()) + ' ' + this._monthToString(o.getMonth(), true) + ' ' + ' (' + s1 + ')';
        }
        //meses
        if (d < (60 * 60 * 24 * 7 * 4 * 12)) {
            if (Math.round(d / (60 * 60 * 24 * 7 * 4)) < 2) {
                s1 = Math.round(d / (60 * 60 * 24 * 7 * 4)) + " mês atrás";
            } else {
                s1 = Math.round(d / (60 * 60 * 24 * 7 * 4)) + " meses atrás";
            }

            return this._leadingZero(o.getDate()) + ' ' + this._monthToString(o.getMonth(), true) + ' ' + (o.getFullYear() != c.getFullYear() ? this._yearToString(o.getFullYear(), false) + ' ' : '') + '(' + s1 + ')';
        }
        //anos
        if (d > (60 * 60 * 24 * 7 * 4 * 12)) {
            if (Math.round(d / (60 * 60 * 24 * 7 * 4)) < 24) {
                s1 = Math.floor(d / (60 * 60 * 24 * 7 * 4 * 12)) + " ano atrás";
            } else {
                s1 = Math.floor(d / (60 * 60 * 24 * 7 * 4 * 12)) + " anos atrás";
            }

            return this._leadingZero(o.getDate()) + ' ' + this._monthToString(o.getMonth(), true) + ' ' + o.getFullYear() + ' (' + s1 + ')';
        }
        return '';
    };
    this._monitoreStop = function () {
        var id = this._getTimerMonitoreId();
        if (id) {
            clearTimeout(id);
            this._setTimerMonitoreId(null);
        }
    };
    this._monitoreStart = function () {
        this._monitoreStop();
        var id = setTimeout('new sliceTime()._monitoreRun()', 20 * 1000);
        this._setTimerMonitoreId(id);
        this._store();
    };
    this._monitoreRun = function () {
        this._monitoreStop();
        this._updateAll();
    };
    this._detectFormatInTag = function (o) {
        var s = o.innerHTML.toLowerCase();
        if (s.indexOf('[onlytime]') > -1) {
            return slice.list.time.format.OnlyTime;
        }
        if (s.indexOf('[onlytext]') > -1) {
            return slice.list.time.format.OnlyText;
        }

        return slice.list.time.format.Full;
    };
    this._updateAll = function () {
        /// <summary>Atualiza o tempo de todos os containeres adicionados</summary>
        var removed = new Array();
        var total = this._getContainerList().length;
        for (var n = 0; n != total; n++) {
            var o = this._getContainerList()[n];
            if (document.getElementById(o.containerId)) {
                this.setTimeRFC(o.time);
                this.setFormat(o.format);
                this.write(o.containerId);
            } else {
                //armazena o índice para remoção
                removed.push(n);
            }
        }
        //remove os elementos não mais presentes do final para o começo para preservar o índice
        while (removed.length > 0) {
            this._getContainerList().splice(removed.pop(), 1);
        }
        //atualiza
        this._store();
        //refaz loop
        this._monitoreStart();
    };
    this._applyTitle = function (o) {
        var d = new Date(o.getAttribute('datetime'));
        var s = '';
        s += ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'][d.getDay()] + ', ';
        s += this._leadingZero(d.getDate()) + ' de ' + this._monthToString(d.getMonth(), false).toLowerCase() + ' de ' + d.getFullYear() + ' � s ';
        s += this._leadingZero(d.getHours()) + ':' + this._leadingZero(d.getMinutes());
        o.setAttribute('title', s);
    };
    this._updateByTagTime = function () {
        var d = document.getElementsByTagName('time');
        var total = d.length;
        for (var n = 0; n != total; n++) {
            var o = d[n];
            if (!o.getAttribute('datetime')) {
                continue;
            }
            //define id se nao houver
            if (!o.getAttribute('id')) {
                o.setAttribute('id', 'time_' + this._getContainerIncrement());
                this._setContainerIncrement(this._getContainerIncrement() + 1);
            }
            //define titulo se nao houver
            if (!o.getAttribute('title')) {
                this._applyTitle(o);
            }
            this.setFormat(this._detectFormatInTag(o));
            this.setTimeRFC(o.getAttribute('datetime'));
            this.update(o.getAttribute('id'));
        }
    };
    this._store = function () {
        window._sliceTime = this;
    };
    this._load = function () {
        var o = window._sliceTime;
        if (!o) {
            return;
        }
        this.setTimeRFC(o._getTimeRFC());
        this.setFormat(o._getFormat());
        this._setContainerId(o._getContainerId());
        this._setTimerMonitoreId(o._getTimerMonitoreId());
        this._setContainerList(o._getContainerList());
        this._setContainerIncrement(o._getContainerIncrement());
    };
    this._dispose = function () {
        /// <summary>Libera todos os recursos</summary>
        window._sliceTime = null;
        this._monitoreStop();
    };
    //#endregion
    //#region propriedades públicas
    this.setFormat = function (format) {
        /// <summary>Define o formato amigável a retornar</summary>
        /// <param name="format" type="String">O formato de retorno, utilize o list slice.list.time.format para obter a lista de formatos</param>
        this._format = format;
        return this;
    };
    this.setTimeRFC = function (timeRFC) {
        /// <summary>Define a data em formato rfc ou iso a ser convertida</summary>
        /// <param name="timeRFC" type="String">a data em formato rfc ou iso</param>
        this._timeRFC = timeRFC;
        return this;
    };
    this.update = function (containerId) {
        /// <summary>Define um container que terá o tempo informado atualizado com frequência inferior a 1 minuto</summary>
        /// <param name="id" type="String">A id do objeto que contém ou deve conter a data, como span ou div</param>
        if (!containerId) {
            this._updateByTagTime();
            return this;
        }
        //armazena id do container
        //chama o timer
        this._monitoreStart();
        this._setContainerId(containerId);
        //se o elemento já estiver, nao adiciona
        var total = this._getContainerList().length;
        for (var n = 0; n != total; n++) {
            var o1 = this._getContainerList()[n];
            if (o1.containerId == this._getContainerId()) {
                return this;
            }
        }

        var o = new Object();
        o = {
            time: this._getTimeRFC(),
            format: this._getFormat(),
            containerId: this._getContainerId()
        }
        new sliceContainer(this._getContainerId()).write(this.get());
        //adiciona
        this._getContainerList().push(o);
        this._store();
        return this;
    };
    this.write = function (containerId) {
        /// <summary>Escreve a data no interior de um container</summary>
        /// <param name="containerId" type="String">A id do objeto que contém ou deve conter a data, como span ou div</param>
        this._setContainerId(containerId);
        var d = document.getElementById(containerId);
        if (d) {
            d.innerHTML = this.get();
        }
        return this;
    };
    this.get = function () {
        /// <summary>Retorna uma string em formato amigável</summary>
        var s = this._getFullText();
        var p, e;
        switch (this._getFormat()) {
            //data sem o comparação em minutos, horas, dias   
            case slice.list.time.format.OnlyTime:
                p = s.indexOf(' (');
                if (p == -1) {
                    break;
                }
                s = s.substring(0, p);
                break;
            //apenas a comparação em minutos, horas, dias   
            case slice.list.time.format.OnlyText:
                p = s.indexOf('(');
                if (p == -1) {
                    break;
                }
                e = s.indexOf(')');
                if (e == -1) {
                    break;
                }
                s = s.substring(p + 1, e);
                break;
            //formato completo data + comparação   
            case slice.list.time.format.Full:
            default:
                //não faz naad
                break;
        }
        return s;
    };
    //#endregion
    //#region construtor
    this._load();
    //#endregion
}