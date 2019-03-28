<p>
  Je hebt een nieuw bericht van het contactformulier van Beachvolleybal Bladel Live!
</p>
<hr />
<p><strong>Contactgegevens: </strong></p>
<ul>
  <li>Naam: <strong>{{ $name }}</strong></li>
  <li>Email: <strong>{{ $email }}</strong></li>
</ul>
<hr>
<p>
  <strong>Dit is bericht:</strong>
</p>
<p>
  @foreach ($messageLines as $messageLine)
    {{ $messageLine }}<br>
  @endforeach
</p>
<hr>