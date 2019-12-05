package com.easywaste.app

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.EditText

import androidx.fragment.app.Fragment
import androidx.appcompat.app.AppCompatActivity
import android.text.InputFilter
import com.easywaste.app.Clases.Validar


class RegistrarFragment : Fragment(){

    var btnRegistrar:Button? =null
    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?, savedInstanceState: Bundle?): View? {
        val v = inflater.inflate(R.layout.registrar_usuario, container, false)
        val activity = activity as AppCompatActivity?
        if (activity != null) {
            activity.title = "Registrar"
            activity.supportActionBar!!.show()
            activity.supportActionBar!!.setDisplayHomeAsUpEnabled(true)
            activity.supportActionBar!!.setDisplayShowHomeEnabled(true)
        }
        val txtDNI = v.findViewById<EditText>(R.id.dni)

        val txtNombre = v.findViewById<EditText>(R.id.nombre)
        txtNombre.filters += InputFilter.AllCaps()
        val txtApellido = v.findViewById<EditText>(R.id.apellido)
        txtApellido.filters += InputFilter.AllCaps()
        val txtTelefono = v.findViewById<EditText>(R.id.telefono)
        val txtEmail = v.findViewById<EditText>(R.id.correo)
        val txtPass = v.findViewById<EditText>(R.id.password)


        btnRegistrar = v.findViewById<Button>(R.id.btnRegistrar)
        val btnLogin  = v.findViewById<Button>(R.id.btnLogin)
        btnRegistrar?.setOnClickListener{
            btnRegistrar?.isEnabled = false


            var valido = false
            if(Validar.vacio(txtDNI)) {
                Validar.txtErr(txtDNI, "Ingrese Número de DNI")
            }else if( ! Validar.strSize(txtDNI,   8)) {
                Validar.txtErr(txtDNI,  "El número de DNI debe tener 8 digitos")
            }else if(Validar.vacio(txtNombre)) {
                Validar.txtErr(txtNombre, "Ingrese Nombre")
            }else if(Validar.vacio(txtApellido)){
                Validar.txtErr(txtApellido,  "Ingrese Apellido")
            }else if(Validar.vacio(txtTelefono)){
                Validar.txtErr(txtTelefono,  "Ingrese Teléfono")
            }else if (Validar.strMenorA(txtTelefono, 6)){
                Validar.txtErr(txtTelefono,  "Número de teléfono inválido")
            }else if(Validar.vacio(txtEmail)){
                Validar.txtErr(txtEmail, "Ingrese correo electrónico" )
            }else if(! Validar.strEmail(txtEmail)){
                Validar.txtErr(txtEmail, "Correo inválido" )
            } else if(Validar.vacio(txtPass)){
                Validar.txtErr(txtPass, "Ingrese contraseña" )
            }else if(Validar.strMenorA(txtPass,6)){
                Validar.txtErr(txtPass, "Mínimo 6 caracteres" )
            }else{
                valido = true
            }
            /*
            if(valido){
                val cliente = ClsCliente(txtDNI.text.toString().trim(),
                    txtNombre.text.toString().trim(), txtApellido.text.toString().trim(),txtEmail.text.toString().trim(),
                    txtPass.text.toString().trim(), txtTelefono.text.toString().trim())
                registrarCliente(cliente)

            }else{
                AlertaMensaje.mostrarError(activity!!,"Complete correctamente los campos.")
                btnRegistrar?.isEnabled = true

            }
*/
        }
        btnLogin.setOnClickListener{
            btnLogin.isEnabled = false
            val fragmentTransaction = fragmentManager?.beginTransaction()
            fragmentTransaction?.replace(R.id.fragmento, LoginProveedorFragment())
            fragmentTransaction?.commit()
            btnLogin.isEnabled = true

        }



        return v
    }
/*
    fun registrarCliente(cliente:ClsCliente){
        val activity = activity as AppCompatActivity?

        btnRegistrar?.isEnabled = false
        Toast.makeText(context,  "Espere ...", Toast.LENGTH_LONG).show()

        val stringRequest = object : StringRequest(POST, VAR.url("registrar"),
            Response.Listener<String> { response ->
                val rpt = VAR.wsResponse(response)
                if(rpt!=null){
                    if(rpt.outstate ){

                        val msg = "Registro completado, ingrese su correo y contraseña."
                        AlertaMensaje.mostrarSuccess(activity!! ,msg)

                        val acti = activity as LoginActivity
                        acti.cambiarFragment(LoginProveedorFragment())

                    }else{

                        val msg = rpt.outdescription
                        AlertaMensaje.mostrarError(activity!!,msg)

                    }


                }else{
                    Toast.makeText(context,  "Error de conexión", Toast.LENGTH_LONG).show()

                }

                btnRegistrar?.isEnabled = true
            },
            Response.ErrorListener {
                btnRegistrar?.isEnabled = true
                Toast.makeText(context,  "Error de conexión", Toast.LENGTH_LONG).show()
            }) {
            override fun getParams(): Map<String, String> {
                return cliente.params()
            }

        }

        val requestQueue = Volley.newRequestQueue(context)
        requestQueue.add(stringRequest)
    }

 */
}