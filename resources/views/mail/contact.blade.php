<p style="text-align: center;">
    <img alt="" src="{{ URL::asset( 'public/storage/logo.png' ) }}" style="width:300px;">
</p>

<p>&nbsp;</p>

<table style="width:500px; margin:0 auto; border:none; border-collapse:separate; border-spacing:0;">
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center; background:#F4F4F4; line-height:40px; font-weight:bold;">
                Contato
            </td>
        </tr>
        <tr>
            <td style="width:80px;">Nome:</td>
            <td>{{ $contact->name }}</td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td>{{ $contact->email }}</td>
        </tr>
        <tr>
            <td>Assunto:</td>
            <td>{{ $contact->subject }}</td>
        </tr>
        <tr>
            <td valign="top">Mensagem:</td>
            <td>{{ nl2br( $contact->message ) }}</td>
        </tr>
    </tbody>
</table>
