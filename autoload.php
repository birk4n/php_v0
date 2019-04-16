<?php

require_once("elephant.io-3.3.0/src/Client.php");
require_once("elephant.io-3.3.0/src/EngineInterface.php");
require_once("elephant.io-3.3.0/src/AbstractPayload.php");
require_once("elephant.io-3.3.0/src/Exception/SocketException.php");
require_once("elephant.io-3.3.0/src/Exception/MalformedUrlException.php");
require_once("elephant.io-3.3.0/src/Exception/ServerConnectionFailureException.php");
require_once("elephant.io-3.3.0/src/Exception/UnsupportedActionException.php");
require_once("elephant.io-3.3.0/src/Exception/UnsupportedTransportException.php");

require_once("elephant.io-3.3.0/src/Engine/AbstractSocketIO.php");
require_once("elephant.io-3.3.0/src/Engine/SocketIO/Session.php");
require_once("elephant.io-3.3.0/src/Engine/SocketIO/Version0X.php");
require_once("elephant.io-3.3.0/src/Engine/SocketIO/Version1X.php");
require_once("elephant.io-3.3.0/src/Engine/SocketIO/Version2X.php");
require_once("elephant.io-3.3.0/src/Payload/Decoder.php");
require_once("elephant.io-3.3.0/src/Payload/Encoder.php");
