VMShowroomIN._I1 = [];
VMShowroomIN._I2 = [];
VMShowroomIN._I1['20'] = 'C90,Chevrolet,7;CF0,Citroën,4;F60,Fiat,4;F90,Ford,28;H30,Honda,1;H60,Hyundai,2;K30,KIA,2;MF0,Mitsubishi,3;N30,Nissan,1;P30,Peugeot,4;R30,Renault,4;T30,Toyota,1;V60,Volkswagen,4';
VMShowroomIN._I2['20'] = 'P30,5845,206,1;P30,4004,207 Sedan,2;P30,5847,207 SW,1;C90,6992,Agile,1;CF0,7196,Aircross,1;V60,7138,Amarok,1;CF0,5247,C3,1;CF0,7224,C3 Picasso,1;CF0,5248,C4,1;C90,5171,Captiva,2;K30,5543,Cerato,1;T30,5980,Corolla,1;V60,6016,Crossfox,1;F90,5376,Ecosport,4;F90,5377,Edge,1;F90,5394,Fiesta Hatch,9;F90,5393,Fiesta Sedan,3;H30,5460,Fit,1;F90,5397,Focus Hatch,1;F90,5399,Fusion,1;V60,6025,Gol,1;F60,5343,Idea,2;F90,5403,KA,2;R30,5916,Logan,1;R30,5918,Mégane Sedan,1;C90,5202,Montana,3;F90,7344,New Fiesta Hatch,1;F90,7345,New Fiesta Sedan,1;MF0,5798,Outlander,2;MF0,5799,Pajero,1;F60,5348,Palio,1;F60,7270,Palio Adventure,1;V60,6035,Parati,1;C90,5208,Prisma,1;F90,5413,Ranger,5;R30,5920,Sandero,2;H60,5484,Santa Fé,1;K30,5552,Sorento,1;N30,5835,Tiida Hatch,1;H60,5491,Tucson,1';
VMShowroomIN.handleInventory();
function VMAutoComplete() {
    this.bkv = function () {
        this.gns = VMShowroom.sst();
        this.gns.tbs = this;
        this.kdw = this.gns.kdw;
        with (VMShowroomIN.sst()) {
            this.tgk = tgk;
            this.vql = vql;
            this.mgp = mgp;
            this.gnw = gnw;
            this.jdc = jdc;
        }
        this.pzr();
    };
    this.pzr = function () {
        if (!document.VMShowroom_SearchForm) return;
        if (this.xpw = document.VMShowroom_SearchForm.hwg) {
            if (!(this.gxl = document.getElementById("VMShowroom_SearchList"))) {
                var ttf = VMShowroom.sst().rsp(this.xpw);
                this.gxl = this.jgm(ttf);
            }
            var rmn = this.gns.kdt['TX0'] || '#000000', sgz = this.gns.kdt['BK3'] || '#ffffff';
            this.djk = this.xpw.value;
            this.lvq = -1;
            this.mdj = [];
            this.thg = null;
            this.zjx = 0;
            this.tdf = [sgz, rmn];
            this.rsm = [rmn, sgz];
            VMThread.sst().xbv('tbp', "VMAutoComplete.sst().brk()", 100);
            this.kkw("hidden");
            document.onkeydown = this.kdf;
            document.onkeyup = this.hsc;
        } else if (document.VMShowroom_SearchForm.mhv) {
            VMShowroomIN.sst().cwc();
        }
    };
    this.kkw = function (zgt) {
        var zrx = document.getElementById("VMShowroom_SearchListBox");
        var bpg = document.VMShowroom_SearchForm.hwg;
        var ttf = VMShowroom.sst().rsp(bpg);
        zrx.style.position = 'absolute';
        zrx.style.top = (ttf.top + ttf.height - 1) + "px";
        zrx.style.left = ttf.left + "px";
        zrx.style.width = (ttf.width - 2) + "px";
        zrx.style.visibility = zgt;
        var ttf = VMShowroom.sst().rsp(zrx);
    };
    this.jgm = function (ttf) {
        var fzf = this.gns.kdt['TX0'] || '#000000', gmz = this.gns.kdt['LK2'] || '#0000ff', prq = this.gns.kdt['BD2'] || '#cccccc', sgz = this.gns.kdt['BK3'] || '#ffffff';
        var rrs = document.createElement("div");
        rrs.id = "VMShowroom_SearchListBox";
        rrs.className = "VM_SCHLSTBOX";
        with (rrs.style) {
            position = 'absolute';
            visibility = 'hidden';
            top = (ttf.top + ttf.height - 1) + 'px';
            left = ttf.left + 'px';
            width = (ttf.width - 2) + 'px';
            zIndex = 2147483647;
            borderColor = prq;
            backgroundColor = sgz;
        }
        var xtm = document.createElement("div");
        xtm.id = "VMShowroom_SearchList";
        xtm.className = "VM_SCHLSTDTL";
        with (xtm.style) {
            width = (ttf.width - 8) + 'px';
            color = fzf;
            textAlign = 'left';
        }
        var gbw = document.createElement("div");
        gbw.className = "VM_SCHLSTFOO";
        gbw.innerHTML = '<a href="javascript:VMAutoComplete.sst().vtw();" style="color:' + gmz + '">fechar</a>';
        rrs.appendChild(xtm);
        rrs.appendChild(gbw);
        document.body.appendChild(rrs);
        return xtm;
    };
    this.brk = function () {
        if (!document.VMShowroom_SearchForm) return;
        var knx = document.VMShowroom_SearchForm.hwg.value;
        if (this.djk == knx) return; else if (this.lvq > -1); else if (knx.length > 0) {
            this.mdj = this.gbd(knx.toUpperCase());
            if (this.mdj.length > 0) {
                this.nhv();
                for (var i = 0; i < this.mdj.length; ++i) this.qfd(this.mdj[i]);
                this.kkw("visible");
                this.thg = document.VMShowroom_SearchForm.hwg.value;
            } else {
                this.kkw("hidden");
                this.lvq = -1;
            }
        } else {
            this.kkw("hidden");
            this.lvq = -1;
        }
        this.djk = knx;
    };
    this.qfd = function (glg) {
        var bpg = document.createElement("div");
        bpg.appendChild(document.createTextNode(glg));
        bpg.onmouseover = this.skw;
        bpg.onmouseout = this.crm;
        bpg.onclick = this.ltw;
        this.gxl.appendChild(bpg);
    };
    this.nhv = function () {
        while (this.gxl.hasChildNodes()) {
            var bpg = this.gxl.firstChild;
            this.gxl.removeChild(bpg);
        }
        this.lvq = -1;
    };
    this.gbd = function (mtv) {
        var gsh = '', gnw = this.gnw, mdj = [];
        for (var i = 0; mdj.length < 15 && i < this.vql.length; ++i) {
            var j = -1;
            var wps = 1;
            var xdc = this.vql[i].cpz.length;
            while (wps == 1 && ++j < mtv.length) {
                if (this.vql[i].cpz.charAt(j) != mtv.charAt(j)) {
                    wps = 0;
                    if (j == xdc && mtv.charAt(j) == ' ') {
                        mtv = mtv.substr(j + 1);
                        var xwq = this.tgk[this.vql[i].qgk];
                        gsh = xwq[1] + ' ';
                        gnw = this.jdc[xwq[0]];
                        i = this.vql.length;
                    }
                }
            }
            if (wps == 1)mdj[mdj.length] = this.tgk[this.vql[i].qgk][1];
        }
        for (var i = 0; mdj.length < 15 && i < gnw.length; ++i) {
            var j = -1;
            var wps = 1;
            while (wps == 1 && ++j < mtv.length) {
                if (gnw[i].cpz.charAt(j) != mtv.charAt(j))wps = 0;
            }
            if (wps == 1)mdj[mdj.length] = gsh + this.mgp[gnw[i].qgk][1];
        }
        return mdj;
    };
    this.qgb = function (lvq, lnb) {
        this.gxl.childNodes[lvq].style.background = this.tdf[lnb];
        this.gxl.childNodes[lvq].style.color = this.rsm[lnb];
    };
    this.kdf = function (bmp) {
        var rjp = VMAutoComplete.sst();
        if (!bmp && window.event)bmp = window.event;
        if (bmp) rjp.zjx = bmp.keyCode; else rjp.zjx = event.which;
    };
    this.hsc = function (bmp) {
        var rjp = VMAutoComplete.sst();
        if (document.getElementById("VMShowroom_SearchListBox").style.visibility == "visible") {
            if (rjp.zjx == 40) {
                if (rjp.mdj.length > 0 && rjp.lvq < rjp.mdj.length - 1) {
                    if (rjp.lvq >= 0)rjp.qgb(rjp.lvq, 0); else rjp.thg = rjp.xpw.value;
                    rjp.qgb(++rjp.lvq, 1);
                    rjp.xpw.value = rjp.gxl.childNodes[rjp.lvq].firstChild.nodeValue;
                }
            } else if (rjp.zjx == 38) {
                if (rjp.mdj.length > 0 && rjp.lvq >= 0) {
                    if (rjp.lvq >= 1) {
                        rjp.qgb(rjp.lvq, 0);
                        rjp.qgb(--rjp.lvq, 1);
                        rjp.xpw.value = rjp.gxl.childNodes[rjp.lvq].firstChild.nodeValue;
                    } else {
                        rjp.qgb(rjp.lvq, 0);
                        rjp.xpw.value = rjp.thg;
                        rjp.xpw.focus();
                        rjp.lvq--;
                    }
                }
            } else if (rjp.zjx == 27) {
                rjp.vtw();
            } else if (rjp.zjx == 8) {
                rjp.lvq = -1;
                rjp.djk = -1;
            } else if (rjp.zjx == 32) {
                rjp.kkw("hidden");
                rjp.lvq = -1;
                rjp.djk = -1;
            }
        }
    };
    this.vtw = function () {
        this.xpw.value = this.thg;
        this.kkw("hidden");
        this.lvq = -1;
        this.djk = this.thg;
    };
    this.skw = function () {
        var rjp = VMAutoComplete.sst();
        for (var i = 0; i < rjp.mdj.length; ++i)rjp.qgb(i, 0);
        this.style.background = rjp.tdf[1];
        this.style.color = rjp.rsm[1];
    };
    this.crm = function () {
        var rjp = VMAutoComplete.sst();
        this.style.background = rjp.tdf[0];
        this.style.color = rjp.rsm[0];
    };
    this.ltw = function () {
        var rjp = VMAutoComplete.sst();
        rjp.xpw.value = this.firstChild.nodeValue;
        rjp.xpw.focus();
        rjp.kkw("hidden");
        rjp.lvq = -1;
        rjp.djk = this.firstChild.nodeValue;
    };
};
VMAutoComplete.rjp = null;
VMAutoComplete.sst = function () {
    if (!this.rjp) this.rjp = new VMAutoComplete();
    return this.rjp;
};
VMAutoComplete.initialize = function () {
    VMAutoComplete.sst().bkv();
};
VMAutoComplete.initialize();