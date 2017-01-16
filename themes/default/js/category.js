;(function(exports){
    var byteLength = function(str){
        if(typeof str == "undefined"){
            return 0;
        }
        var aMatch = str.match(/[^\x00-\x80]/g);
        return (str.length + (!aMatch ? 0 : aMatch.length));
    };
    var strLeft = function(str,len){
        var s = str.replace(/\*/g, " ").replace(/[^\x00-\xff]/g, "**");
        str = str.slice(0, s.slice(0, len).replace(/\*\*/g, " ").replace(/\*/g, "").length);
        if(byteLength(str) > len) str = str.slice(0,str.length -1);
        return str;
    };
    var splitNum = function(num){
         num = num + "";
         var re = /(-?\d+)(\d{3})/
         while (re.test(num)) {
             num = num.replace(re, "$1,$2")
         }
         return num;
     };
    var Clz = function(parent) {var propertyName = '___ytreporp___'; var klass = function() {this.init.apply(this, arguments); }; if (parent) {var subclass = function() {}; subclass.prototype = parent.prototype; klass.prototype = new subclass; }; klass.prototype.init = function() {}; klass.prototype.set = function(k,v) {if(!this[propertyName]){this[propertyName] = {}; } var i   = 0, un  = this[propertyName], ns  = k.split('.'), len = ns.length, upp = len - 1, key; while(i<len){key = ns[i]; if(i==upp){un[key] = v; } if(un[key]===undefined){un[key] = {} } un = un[key]; i++; } }; klass.prototype.get = function(k) {if(!this[propertyName]){this[propertyName] = {}; } var i   = 0, un  = this[propertyName], ns  = k.split('.'), len = ns.length, upp = len - 1, key; while(i<len){key = ns[i]; if(i==upp){return un[key]; } if(un[key]===undefined){un[key] = {} } un = un[key]; i++; } }; klass.fn = klass.prototype; klass.fn.parent = klass; klass._super = klass.__proto__; klass.extend = function(obj) {var extended = obj.extended; for (var i in obj) {klass[i] = obj[i]; } if (extended) extended(klass) }; klass.include = function(obj) {var included = obj.included; for (var i in obj) {klass.fn[i] = obj[i]; } if (included) included(klass) }; return klass; };
    // 数据加载
    var Loader = new Clz;
    Loader.include({
        init:function(opts){
            this.setStat();
            this.setOpt(opts);
            this.getData();
        },
        setStat:function(){
            this.set('stat',{
                loading:0
            });
        },
        setOpt:function(opts){
            this.set('opts',jQuery.extend({
                api:'http://platform.sina.com.cn/slide/album_photo_col?app_key=1985696825&photo_col_id=20&tags=cat&tagmode=any&format=json',
                page:1,
                num:10,
                success:function(){}
            },opts||{}));
        },
        getData:function(){
            var self = this;
            var opts = self.get('opts');
            var api = opts.api+'&page='+opts.page+'&num='+opts.num;
            var loading = self.get('stat.loading');
            if(loading){
                return;
            }
            self.set('stat.loading',1);
            self._before();
            var cbName = 'slideNewsSinaComCnCB';
            window[cbName] = function(data){
                self._sussess(data,self);
                opts.success(data,self);
                self.set('stat.loading',0);
            };
            // HACK ie6
            setTimeout(function(){
                // jQuery.ajax({
                //   type: 'GET',
                //   url: api,
                //   dataType: 'jsonp',
                //   jsonp:'jsoncallback',
                //   success:function(data){
                //     self._sussess(data,self);
                //     opts.success(data,self);
                //     self.set('stat.loading',0);
                //   }
                // });
                $.getScript(api+'&jsoncallback='+cbName,
                  function(data) {

                  });
            },0);
        },
        _before:function(){
        },
        _sussess:function(data){
        }
    });
    // 数据加载及分页
    var PageLoader = new Clz(Loader);
    PageLoader.include({
        init:function(opts){
            this.setStat();
            this.setOpt(opts);
            this.getDom();
            this.getData();
        },
        getDom:function(){
            var self = this;
            var id = self.get('opts.id');
            if(!id){
                return;
            }
            var getNodes = function(wrap){
                var attr = 'node-type';
                var wrap = $('#'+wrap);
                var nodes = $("["+attr+"]",wrap);
                var nodesObj = {};
                nodesObj.wrap = wrap;
                nodes.each(function(i){
                    var item = $(this);
                    nodesObj[item.attr(attr)] = item;
                });
                return nodesObj;
            };
            var dom = getNodes(id);
            dom.pagination.html('<span node-type="pager"></span> <span class="pager-a-txt"> &nbsp;&nbsp;共<span node-type="total"></span>页&nbsp;&nbsp;到第 <input type="text" node-type="num"> 页 </span> <a href="javascript:;" class="pager-a-jump" node-type="btn">确定</a>');
            self.set('dom',getNodes(id));
        },
        setStatDom:function(html){
            var wrap = this.get('dom.items');
            wrap.html(html);
        },
        _before:function(){
            this.setStatDom('<p class="loading"><span>加载中...</span></p>');
        },
        pageRender:function(data){
            var self = this;
            var stat = self.get('stat');
            if(stat.pageInit){
                return;
            }
            self.set('stat.pageInit',1);
            var dom = self.get('dom');
            //数据
            var items = dom.items;
            // 分页
            var pager = dom.pager;
            // 每页条数
            var num = self.get('opts.num');
            // 总条数
            var itemsLen = parseInt(data.total);
            // 共多少页
            // 如果总数小于每页数，应该隐藏分页
            if(!(itemsLen>num)){
                dom.pagination.hide();
            }else{
                dom.pagination.show();
            }
            if(itemsLen==0){
                self.setStatDom('<p class="empty"><span>暂时没有数据</span></p>');
            }
            dom.total.html(Math.ceil(itemsLen/num));
            pager.pagination(itemsLen,{
                items_per_page:num,
                num_display_entries:8,
                current_page:0,
                num_edge_entries:2,
                link_to:"javascript:;",
                prev_text:"上一页",
                next_text:"下一页",
                ellipse_text:"...",
                prev_show_always:true,
                next_show_always:true,
                callback:function(current){
                    self.set('opts.page',current+1);
                    self.getData.call(self)
                }
            });
            // 点击或回车跳转
            var btn = dom.btn;
            var num = dom.num;
            var jumpTo = function(){
                var page = num.attr('value');
                page = parseInt(page,10)-1;
                if(pager){
                    pager.trigger('setPage', [page]);
                }
            }
            btn.on('click',function(){
                jumpTo();
            });
            num.on('keyup',function(event){
                var keyCode = event.keyCode;
                if(keyCode=='13'){
                    jumpTo();
                }
            });
        },
        _sussess:function(data,self){
            this.pageRender(data);
        }
    });
    var app = {};

    // 喜欢按钮与评论按钮
    app.renderLikeNum = function(wrap){
        // vote
        // http://comment5.news.sina.com.cn/count/info
        var attrVal = 'smallLike';
        var nodes = $("[node-type='"+attrVal+"']",wrap);
        var getId = function(node){
            return node.getAttribute('action-data');
        };
        var ids = (function(nodes){
            var ids = [];
            for (var i = 0, len = nodes.length; i < len; i++) {
                var item = nodes[i];
                var id = item.getAttribute('action-data');
                ids.push(id);
            }
            if(ids.length==1){
                ids = [ids[0],'noids'];
            }
            return ids.join(',');
        })(nodes);
        var api = 'http://comment5.news.sina.com.cn/count/info?key='+ids;
        var render = function(data,nodes){
            var data = data.result.data;
            for (var i = 0, len = nodes.length; i < len; i++) {
                var item = nodes[i];
                var id = getId(item);
                var num = 0;
                if(data&&data[id]){
                    num = data[id]['vote']||0;
                    if(num>9999){
                        num = '9,999+';
                    }else{
                        num = splitNum(num);
                    }
                }
                item.innerHTML = '<i></i>'+num;
            }
        };
        jQuery.ajax({
          type: 'GET',
          url: api,
          dataType: 'jsonp',
          success:function(data){
            render(data,nodes);
          }
        });
    };
    app.renderCmntNum = function(wrap){
        // total
      var attrVal = 'smallCmnt';
      var nodes = $("[node-type='"+attrVal+"']",wrap);
      var getId = function(node){
        return id = (node.getAttribute('action-data')).replace('_',':')+':1';
      };
      var ids = (function(nodes){
          var ids = [];
          for (var i = 0, len = nodes.length; i < len; i++) {
              var item = nodes[i];
              var id = getId(item);
              ids.push(id);
          }
          return ids.join(',');
      })(nodes);
      var api = 'http://comment5.news.sina.com.cn/cmnt/count?format=json&newslist='+ids;
      var render = function(data,nodes){
          var count = data.result.count;
          for (var i = 0, len = nodes.length; i < len; i++) {
              var item = nodes[i];
              var id = getId(item);
              if(count&&count[id]){
                  num = count[id]['total']||0;
                  if(num>9999){
                      num = '9,999+';
                  }else{
                    num = splitNum(num);
                  }
              }
              item.innerHTML = '<i></i>'+ num;
          }
      };
      jQuery.ajax({
        type: 'GET',
        url: api,
        dataType: 'jsonp',
        success:function(data){
          render(data,nodes);
        }
      });
    };
    app.bindLikeNum = function(wrap,clz){
        var attrVal = 'smallLike';
        var baseUrl = 'http://www.sinaimg.cn/dy/deco/2013/1011/';
        var body = $('body');
        var voted = $('<img src="'+baseUrl+'voted.png" alt="已顶" style="display:none;" />').appendTo(body);
        var voting = $('<img src="'+baseUrl+'vote.png" alt="+1" style="display:none;"  />').appendTo(body);
        var voteTimeout = null;
        var showTip = function(ele,pos){
            var offset = pos.offset();
            var gap = pos.width()/2;
            ele.css({
                position:'absolute',
                top:offset.top,
                left:offset.left-gap
            });
            ele.animate({opacity: 'show', top: offset.top-25}, 'fast');
            voteTimeout = setTimeout(function(){
                ele.animate({opacity: 'hide', top: offset.top}, 'fast');
            },1e3);
        };
        // wrap.on('click',"[node-type='"+attrVal+"']",function(event){
        //     var $this = $(this);
        //     if($this.data(clz)){
        //         showTip(voted,$this);
        //         return;
        //     }
        //     // 提交
        //     var id = this.getAttribute('action-data');
        //     var url = "http://comment5.news.sina.com.cn/count/submit?key=" + id + "&group=vote";
        //     (new Image()).src = url;
        //     // 修改ui
        //     var num = this.innerHTML;
        //     this.innerHTML = parseInt(num,10)+1;
        //     $this.addClass(clz);
        //     this.title="已顶";
        //     $this.data(clz,true);
        //     if(voting){
        //         showTip(voting,$this);
        //     }
        // });
    };
    app.bindIntro = function(wrap,clz){
        // total
        var attrVal = 'introTrigger';
        wrap.on('click', "[node-type='" + attrVal + "']", function(event) {
            var $this = $(this);
            var parent = $this.parent();
            parent.toggleClass(clz);
        });
    };
    app.placeholder = (function(){
        var supportPlaceholder = 'placeholder' in document.createElement('input');
        var toggleTip = function(input,text){
            defaultValue = input.defaultValue;
            $(input).addClass('gray');
            input.value = text;
            input.onfocus = function(){
                if(input.value === defaultValue || input.value === text){
                    this.value = '';
                    $(input).removeClass('gray');
                }
            }
            input.onblur = function(){
                if(input.value === ''){
                    this.value = text;
                    $(input).addClass('gray');
                }
            }
        };
        var simulateTip = function(input,text){
            var pwdPlaceholder = document.createElement('input');
            pwdPlaceholder.type='text';
            pwdPlaceholder.className = 'pwd_placeholder gray '+input.className;
            pwdPlaceholder.value=text;
            pwdPlaceholder.autocomplete = 'off';
            input.style.display='none';
            input.parentNode.appendChild(pwdPlaceholder);
            pwdPlaceholder.onfocus = function(){
                pwdPlaceholder.style.display = 'none';
                input.style.display = '';
                input.focus();
            }
            input.onblur = function(){
                if(input.value === ''){
                    pwdPlaceholder.style.display='';
                    input.style.display='none';
                }
            }
        };
        var placeholder = function(input){
            // console.log(input);
            //如果input不存在或者支持placeholder,返回
            if(!input||supportPlaceholder){
                return;
            }
            //已经初始化，hasPlaceholder为1
            var hasPlaceholder = input.getAttribute('hasPlaceholder')||0;
            if(hasPlaceholder=='1'){
                return;
            }

            //如果没有placeholder或者没有placeholder值，返回
            var text = input.getAttribute('placeholder');

            if(!text){
                //ie10 下的ie7 无法用input.getAttribute('placeholder')取到placeholder值，奇怪！
                if(input.attributes&&input.attributes.placeholder){
                    text=input.attributes.placeholder.value;
                }
            }
            var tagName = input.tagName;
            if(tagName=='INPUT'){
                var inputType = input.type;
                if(inputType == 'password'&&text){
                    simulateTip(input,text);
                }else if(inputType=='text'&&text){
                    toggleTip(input,text);
                }
            }else if(tagName=='TEXTAREA'){
                toggleTip(input,text);
            }
            input.setAttribute('hasPlaceholder','1');
        };
        return function(inputs){
                for (var i = inputs.length - 1; i >= 0; i--) {
                    var input = inputs[i]
                    placeholder(input);
                };
            };
    })();
    app.allPlaceholder = function(){

        var inputs = document.getElementsByTagName('input');
        var areas = document.getElementsByTagName('textarea');
        var placeholder = app.placeholder;
        placeholder(inputs);
        placeholder(areas);
    };
    var PhotoBase = exports.PhotoBase||{};
    PhotoBase.PageLoader = PageLoader;
    PhotoBase.app = app;
    PhotoBase.util = {
        Clz:Clz,
        strLeft:strLeft
    };
    // 页面全局变量
    PhotoBase.page = {};
    exports.PhotoBase = PhotoBase;

})(window);

/**
 * This jQuery plugin displays pagination links inside the selected elements.
 *
 * This plugin needs at least jQuery 1.4.2
 *
 * @author Gabriel Birke (birke *at* d-scribe *dot* de)
 * @version 2.2
 * @param {int} maxentries Number of entries to paginate
 * @param {Object} opts Several options (see README for documentation)
 * @return {Object} jQuery Object
 */
 (function($){
    /**
     * @class Class for calculating pagination values
     */
    $.PaginationCalculator = function(maxentries, opts) {
        this.maxentries = maxentries;
        this.opts = opts;
    }

    $.extend($.PaginationCalculator.prototype, {
        /**
         * Calculate the maximum number of pages
         * @method
         * @returns {Number}
         */
        numPages:function() {
            return Math.ceil(this.maxentries/this.opts.items_per_page);
        },
        /**
         * Calculate start and end point of pagination links depending on
         * current_page and num_display_entries.
         * @returns {Array}
         */
        getInterval:function(current_page)  {
            var ne_half = Math.floor(this.opts.num_display_entries/2);
            var np = this.numPages();
            var upper_limit = np - this.opts.num_display_entries;
            var start = current_page > ne_half ? Math.max( Math.min(current_page - ne_half, upper_limit), 0 ) : 0;
            var end = current_page > ne_half?Math.min(current_page+ne_half + (this.opts.num_display_entries % 2), np):Math.min(this.opts.num_display_entries, np);
            return {start:start, end:end};
        }
    });

    // Initialize jQuery object container for pagination renderers
    $.PaginationRenderers = {}

    /**
     * @class Default renderer for rendering pagination links
     */
    $.PaginationRenderers.defaultRenderer = function(maxentries, opts) {
        this.maxentries = maxentries;
        this.opts = opts;
        this.pc = new $.PaginationCalculator(maxentries, opts);
    }
    $.extend($.PaginationRenderers.defaultRenderer.prototype, {
        /**
         * Helper function for generating a single link (or a span tag if it's the current page)
         * @param {Number} page_id The page id for the new item
         * @param {Number} current_page
         * @param {Object} appendopts Options for the new item: text and classes
         * @returns {jQuery} jQuery object containing the link
         */
        createLink:function(page_id, current_page, appendopts){
            var lnk, np = this.pc.numPages();
            page_id = page_id<0?0:(page_id<np?page_id:np-1); // Normalize page id to sane value
            appendopts = $.extend({text:page_id+1, classes:""}, appendopts||{});
            if(page_id == current_page){
                lnk = $("<span class='current'>" + appendopts.text + "</span>");
            }
            else
            {
                lnk = $("<a>" + appendopts.text + "</a>")
                    .attr('href', this.opts.link_to.replace(/__id__/,page_id));
            }
            if(appendopts.classes){ lnk.addClass(appendopts.classes); }
            if(appendopts.rel){ lnk.attr('rel', appendopts.rel); }
            lnk.data('page_id', page_id);
            return lnk;
        },
        // Generate a range of numeric links
        appendRange:function(container, current_page, start, end, opts) {
            var i;
            for(i=start; i<end; i++) {
                this.createLink(i, current_page, opts).appendTo(container);
            }
        },
        getLinks:function(current_page, eventHandler) {
            var begin, end,
                interval = this.pc.getInterval(current_page),
                np = this.pc.numPages(),
                fragment = $("<span class='pagination'></span>");

            // Generate "Previous"-Link
            if(this.opts.prev_text && (current_page > 0 || this.opts.prev_show_always)){
                fragment.append(this.createLink(current_page-1, current_page, {text:this.opts.prev_text, classes:"prev",rel:"prev"}));
            }
            // Generate starting points
            if (interval.start > 0 && this.opts.num_edge_entries > 0)
            {
                end = Math.min(this.opts.num_edge_entries, interval.start);
                this.appendRange(fragment, current_page, 0, end, {classes:'sp'});
                if(this.opts.num_edge_entries < interval.start && this.opts.ellipse_text)
                {
                    $("<span>"+this.opts.ellipse_text+"</span>").appendTo(fragment);
                }
            }
            // Generate interval links
            this.appendRange(fragment, current_page, interval.start, interval.end);
            // Generate ending points
            if (interval.end < np && this.opts.num_edge_entries > 0)
            {
                if(np-this.opts.num_edge_entries > interval.end && this.opts.ellipse_text)
                {
                    $("<span>"+this.opts.ellipse_text+"</span>").appendTo(fragment);
                }
                begin = Math.max(np-this.opts.num_edge_entries, interval.end);
                this.appendRange(fragment, current_page, begin, np, {classes:'ep'});

            }
            // Generate "Next"-Link
            if(this.opts.next_text && (current_page < np-1 || this.opts.next_show_always)){
                fragment.append(this.createLink(current_page+1, current_page, {text:this.opts.next_text, classes:"next",rel:"next"}));
            }
            $('a', fragment).click(eventHandler);
            return fragment;
        }
    });

    // Extend jQuery
    $.fn.pagination = function(maxentries, opts){

        // Initialize options with default values
        opts = $.extend({
            items_per_page:10,
            num_display_entries:11,
            current_page:0,
            num_edge_entries:0,
            link_to:"#",
            prev_text:"Prev",
            next_text:"Next",
            ellipse_text:"...",
            prev_show_always:true,
            next_show_always:true,
            renderer:"defaultRenderer",
            show_if_single_page:false,
            load_first_page:true,
            callback:function(){return false;}
        },opts||{});

        var containers = this,
            renderer, links, current_page;

        /**
         * This is the event handling function for the pagination links.
         * @param {int} page_id The new page number
         */
        function paginationClickHandler(evt){
            var links,
                new_current_page = $(evt.target).data('page_id'),
                continuePropagation = selectPage(new_current_page);
            if (!continuePropagation) {
                evt.stopPropagation();
            }
            return continuePropagation;
        }

        /**
         * This is a utility function for the internal event handlers.
         * It sets the new current page on the pagination container objects,
         * generates a new HTMl fragment for the pagination links and calls
         * the callback function.
         */
        function selectPage(new_current_page) {
            // update the link display of a all containers
            containers.data('current_page', new_current_page);
            links = renderer.getLinks(new_current_page, paginationClickHandler);
            containers.empty();
            links.appendTo(containers);
            // call the callback and propagate the event if it does not return false
            var continuePropagation = opts.callback(new_current_page, containers);
            return continuePropagation;
        }

        // -----------------------------------
        // Initialize containers
        // -----------------------------------
                current_page = parseInt(opts.current_page);
        containers.data('current_page', current_page);
        // Create a sane value for maxentries and items_per_page
        maxentries = (!maxentries || maxentries < 0)?1:maxentries;
        opts.items_per_page = (!opts.items_per_page || opts.items_per_page < 0)?1:opts.items_per_page;

        if(!$.PaginationRenderers[opts.renderer])
        {
            throw new ReferenceError("Pagination renderer '" + opts.renderer + "' was not found in jQuery.PaginationRenderers object.");
        }
        renderer = new $.PaginationRenderers[opts.renderer](maxentries, opts);

        // Attach control events to the DOM elements
        var pc = new $.PaginationCalculator(maxentries, opts);
        var np = pc.numPages();
        containers.off('setPage').on('setPage', {numPages:np}, function(evt, page_id) {
                if(page_id >= 0 && page_id < evt.data.numPages) {
                    selectPage(page_id); return false;
                }
        });
        containers.off('prevPage').on('prevPage', function(evt){
                var current_page = $(this).data('current_page');
                if (current_page > 0) {
                    selectPage(current_page - 1);
                }
                return false;
        });
        containers.off('nextPage').on('nextPage', {numPages:np}, function(evt){
                var current_page = $(this).data('current_page');
                if(current_page < evt.data.numPages - 1) {
                    selectPage(current_page + 1);
                }
                return false;
        });
        containers.off('currentPage').on('currentPage', function(){
                var current_page = $(this).data('current_page');
                selectPage(current_page);
                return false;
        });

        // When all initialisation is done, draw the links
        links = renderer.getLinks(current_page, paginationClickHandler);
        containers.empty();
        if(np > 1 || opts.show_if_single_page) {
            links.appendTo(containers);
        }
        // call callback function
        if(opts.load_first_page) {
            opts.callback(current_page, containers);
        }
    } // End of $.fn.pagination block

})(jQuery);
