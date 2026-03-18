@extends('layouts.app')

@section('content')
<style>
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Nunito', sans-serif;
    color: white;
    background: url('{{ asset('images/15080651_tp201-sasi-21.jpg') }}') no-repeat center center/cover;
    background-attachment: fixed;
    background-size: cover;
    display: flex;
    flex-direction: column;
}

body::after {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to right,
        rgba(0, 0, 0, 0.9) 20%, 
        rgba(0, 0, 0, 0.5) 50%, 
        rgba(0, 0, 0, 0.1) 80% 
    );
    z-index: -1;
}

.hero {
    flex: 1; 
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 10%;
    position: relative;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 1;
    max-width: 800px;
    padding: 30px;
    border-radius: 8px;
}

.hero-content h1 {
    font-size: 3rem;
    margin: 0;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); 
}

.hero-content p {
    font-size: 1.2rem;
    margin: 20px 0;
    font-weight: 500;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6); 
}

.get-started {
    padding: 12px 24px;
    font-size: 1.2rem;
    color: white;
    background-color: rgb(180, 39, 105);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.get-started:hover {
    background-color:rgb(170, 75, 142);
}


footer {
    text-align: center;
    padding: 15px;
   
    color: white;
    width: 100%;
    position: relative;
    bottom: 0;
    z-index: 1;
}



    </style>
    <div class="hero">
        <div class="hero-content">
            <h1>Welcome You can use your Mange Options Admin</h1>
            <a href="{{ route('login') }}" class="get-started">Get Started</a>
        </div>
    </div>
@endsection
