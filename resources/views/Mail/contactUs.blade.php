<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{env('APP_NAME')}}</title>
    </head>
    <body style="width: 100%;">
        <table align="center" border="0" cellspacing="0" width="700px" style="margin:0 auto;background-color: #ffffff;color: rgb(36, 36, 36);font-family: Verdana;">
            <tbody style="background-color: #ffffff;">
                <tr>
                    <td colspan="2" style="text-align: center;border-bottom: 1px solid rgb(231, 231, 231);">
                        <div style="display:table;width: 100%;">
                            <img width="100%" height="100%" style="object-fit: contain;object-position: center;max-height: 70px;display: block;" src="{{asset('storage/'.$generalSetting->path_logo_share)}}" alt="">
                        </div>
                        <div style="margin-top: 10px;padding-bottom: 15px;">
                            <h3 style="
                                font-size: 22px;
                                margin-bottom: 25px;
                                font-weight: 100;
                                font-family: sans-serif;
                                background-color: #000632;
                                padding: 15px 10px;
                                color: #fff;
                            ">
                                Lead da área <b>{{$contactLead->target_lead}}</b>
                            </h3>

                            @foreach ($infomrations as $key => $infomration)
                                @if (isset($infomration['value']))
                                    @if ($infomration['type']<>'file')
                                        <p style="
                                            font-size: 16px;
                                            font-family: sans-serif;
                                            line-height: 27px;
                                            text-align: left;
                                            margin: 0 0 10px 0;
                                            padding: 10px;
                                            background-color: #f1f1f1;
                                        ">
                                            <b>{{$key}}:</b> {{$infomration['value']}}
                                        </p>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="padding: 0 20px;text-align: center;font-size: 12px;background-color: #ffd390;color: rgb(88, 65, 0);"><p>Não deixe de verificar os Leads na área administrativa do site, <a href="{{route('admin.user.login')}}" target="_blank" rel="noopener noreferrer">Clique e confira.</a></p></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0 20px;text-align: center;font-size: 12px;background-color: #303030;color: rgb(255, 255, 255);"><p>{{date('Y')}} {{env('APP_NAME')}} © Todos os direitos reservados.</p></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
