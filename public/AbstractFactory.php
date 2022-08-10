<?php

interface IDoVat
{
    public function congDung();
}

abstract class DoVat implements IDoVat
{
    abstract public function congDung();
}

class Chen extends DoVat {
    public function congDung()
    {
        return 'Dung Com';
    }
}
class Muong extends DoVat {
    public function congDung()
    {
        return 'Dung de chan Canh';
    }
}
class Dua extends DoVat {
    public function congDung()
    {
        return 'Dung de An Com';
    }
}

class ChenNhua extends Chen {
    public function congDungRieng()
    {
        return $this->congDung() . ' bang Nhua';
    }
}
class ChenInox extends Chen {
    public function congDungRieng()
    {
        return $this->congDung() . ' bang Inox';
    }
}
class MuongNhua extends Muong {
    public function congDungRieng()
    {
        return $this->congDung() . ' bang Nhua';
    }
}
class MuongInox extends Muong {
    public function congDungRieng()
    {
        return $this->congDung() . ' bang Inox';
    }
}
class DuaNhua extends Dua {
    public function congDungRieng()
    {
        return $this->congDung() . ' bang Nhua';
    }
}
class DuaInox extends Dua {
    public function congDungRieng()
    {
        return $this->congDung() . ' bang Inox';
    }
}

interface AbstractFactory
{
    public function getProductChen();
    public function getProductMuong();
    public function getProductDua();
}

class NhuaFactory implements AbstractFactory
{
    public function getProductChen()
    {
        return new ChenNhua;
    }
    public function getProductMuong()
    {
        return new MuongNhua;
    }
    public function getProductDua()
    {
        return new DuaNhua;
    }
}

class InoxFactory implements AbstractFactory
{
    public function getProductChen()
    {
        return new ChenInox;
    }
    public function getProductMuong()
    {
        return new MuongInox;
    }
    public function getProductDua()
    {
        return new DuaInox;
    }
}

function client(AbstractFactory $factory) {
    $chen = $factory->getProductChen();
    $muong = $factory->getProductMuong();
    $dua = $factory->getProductDua();
    echo $chen->congDung();
    echo ' ';
    echo $chen->congDungRieng();
    echo '<br>';
    echo $muong->congDung();
    echo ' ';
    echo $muong->congDungRieng();
    echo '<br>';
    echo $dua->congDung();
    echo ' ';
    echo $dua->congDungRieng();
    echo '<br>';
}

client(new NhuaFactory());
echo '<br>';
client(new InoxFactory());