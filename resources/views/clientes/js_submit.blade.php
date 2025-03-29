@php
    $compleUrl = isset($config['compleUrl']) ? $config['compleUrl'] : '';
@endphp
<script>
    $(function(){
        $("#{{$config['frm_id']}}").validate({
            submitHandler: function(form) {
                submitFormulario($("#{{$config['frm_id']}}"),function(res){
                    let btn_press = $('#btn-press-salv').html();
                    lib_formatMensagem('.mens',res.mens,res.color,10000);
                    if(res.exec){
                        console.log(res);
                        if(res.status_contrato){
                            $('[id="txt-config[status_contrato]"]').html(res.status_contrato);
                            $('[id="inp-config[inicioVigencia]"]').attr('type','hidden');
                            $('[id="inp-config[fimVigencia]"]').attr('type','hidden');
                            $('[id="inp-config[premioSeguro]"]').attr('type','hidden');
                        }
                        if(res.numero_operacao){
                            $('[id="txt-config[status_contrato]"]').html(res.status_contrato);
                        }
                    }
                    if(btn_press=='sair'){
                        if(pop){
                                window.opener.popupCallback_vinculo(res); //Call callback function
                                window.close(); // Close the current popup
                                return;
                        }
                        var redirect = $('[btn-volter="true"]').attr('redirect');

                        if(redirect){
                            if(pop){
                                window.opener.popupCallback(function(){
                                    alert('pop some data '+redirect);
                                }); //Call callback function
                                window.close(); // Close the current popup
                                return;
                            }else{
                                if(res.exec)
                                window.location = redirect;
                            }
                        }else if(res.return){
                            if(pop){
                                window.opener.popupCallback(function(){
                                    alert('pop some data '+res.return);
                                }); //Call callback function
                                window.close(); // Close the current popup
                                return;
                            }else{
                                window.location = res.return;
                            }
                        }
                    }else if(btn_press=='permanecer'){
                        if(res.redirect){
                            window.location = res.redirect;
                        }
                    }
                    if(res.errors){
                        alert('erros');
                        console.log(res.errors);
                    }
                },function(res){
                    lib_funError(res);
                },'&'+$('#files').serialize());
                /*
                $(form).submit(function(e){
                    e.preventDefault();

                });
                */

            }
        });
        function btnPres(obj){
            $('#btn-press-salv').remove();
            var btn = '<span id="btn-press-salv" class="d-none">'+obj.attr('btn')+'</span>';
            $(btn).insertAfter(obj);
        }
        $('[type="submit"]').on('click',function(e){
            btnPres($(this));
        });
    });
</script>
