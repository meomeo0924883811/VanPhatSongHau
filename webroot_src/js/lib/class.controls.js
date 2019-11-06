SE.clsControls = (function() {
  //PARAMATER

  //INIT
  function init(){
    radio_init();
    select_init();
    checkbox_init();
  }

  //////////////////////////////////////////////////
  //RADIO
  /*
   <div id="question1" class="row-control process_radio" para_name="answer_question_1" para_valuedefault="1">
   <p>DOEMO</p>
   <a name="answer_q1" class="buttonStyle item active" value="1">A</a>
   <a name="answer_q1" class="buttonStyle item" value="0">B</a>
   </div>
   */

  var para_radio = {
    obj : '.process_radio',
  };

  function radio_init() {
    // js
    $( para_radio.obj ).on('click', '.item', function(e){
      radio_active($(this));
    });

    // css & html
    $( para_radio.obj ).each(function( index ) {
      //insert input hidden
      var name = $(this).attr('para_name');
      var para_valuedefault = $(this).attr('para_valuedefault');

      if( $(this).find('input').length == 0 ) {
        $(this).append('<input type="hidden" value="'+para_valuedefault+'" name="'+name+'" id="'+name+'">');
        $(this).find('.item[value="' + para_valuedefault + '"]').trigger('click');//set default value
      }

    });

  }

  function radio_active($this) {
    $parent = $this.parent();

    $parent.removeClass('error');
    $parent.find('.item').removeClass('active normal');

    $this.addClass('active');

    var name = $parent.attr('para_name');

    //set value
    var obj = $parent.find('input');
    obj.val( $this.attr('value') );

  }

  //END RADIO
  //////////////////////////////////////////////////


  //////////////////////////////////////////////////
  //CHECKBOX
  /*
   <div id="question1" class="row-control process_checkbox" para_name="checkbox_1" checked="true">
   <p>DOEMO</p>
   <a name="answer_q1" class="buttonStyle item active" value="1">A</a>
   <a name="answer_q1" class="buttonStyle item" value="0">B</a>
   </div>
   */
  var para_checkbox = {
    obj : '.process_checkbox'
  };

  function checkbox_init() {
    // js
    $( para_checkbox.obj ).on('click', function(e){
      checkbox_process($(this));
    });

    // css & html
    $( para_checkbox.obj ).each(function( index ) {
      //insert input hidden
      var name = $(this).attr('para_name');
      var isChecked = $(this).attr('isChecked')=='true' ? 1:0;

      if( $(this).find('input').length == 0 ) {
        $(this).append('<input type="hidden" value="" name="'+name+'" id="'+name+'">');

        if(isChecked==1) {
          $(this).addClass('active');
          $(this).removeClass('error');
        }

        checkbox_setvaule($(this));

      }
    });
  }

  function checkbox_process($this) {
    var result = $this.attr('isChecked')=='true' ? 'false':'true';
    $this.attr('isChecked', result);

    if(result=='true') {
      $this.addClass('active');
      $this.removeClass('error');
    }else {
      $this.removeClass('active');
    }

    checkbox_setvaule($this);
  }

  function checkbox_setvaule($this) {
    var isChecked = $this.attr('isChecked')=='true' ? 1:0;
    $this.find('input').val(isChecked);
  }

  //END CHECKBOX
  //////////////////////////////////////////////////

  //////////////////////////////////////////////////
  //SELECT
  var para_select = {
    obj : '.process_select',
    objsub : '.sub-list',
    title : '.title'
  };

  function select_init() {
    // js
    $( para_select.obj ).on('click', '.item', function(e){
      radio_active($(this));
      $(para_select.obj).removeClass('on');
    });

    $(para_select.obj).on('click', para_select.title, function(e){
      $parent = $(this).parent();


      if($parent.hasClass('on')){
        $parent.removeClass('on');
      }else {
        $parent.addClass('on');
      }
    });

    // css & html
    $( para_select.obj ).each(function( index ) {
      //insert input hidden
      var name = $(this).attr('para_name');
      var para_valuedefault = $(this).attr('para_valuedefault');

      //console.log(name, para_valuedefault);

      if( $(this).find('input').length == 0 ) {
        $(this).find('.item[value="' + para_valuedefault + '"]').trigger('click');//set default value
      }
    });

  }

  //END SELECT
  //////////////////////////////////////////////////

  //RETURN
  return {
    init:init
  }
})();