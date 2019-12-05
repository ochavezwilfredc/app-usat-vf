package com.easywaste.app

import android.content.Intent
import androidx.fragment.app.Fragment
import android.os.Bundle
import android.view.ViewGroup
import android.view.LayoutInflater
import android.view.View
import com.google.android.gms.maps.SupportMapFragment
import androidx.appcompat.app.AppCompatActivity
import android.widget.Button
import com.easywaste.app.Clases.AlertaMensaje
import com.easywaste.app.Clases.ClsLocalizacion

class ServicioProveedorRegistrarFragment : Fragment() {

    var loc : ClsLocalizacion? =null
    var accion: String? = ""
    val FRAGMENTO_AGREGAR: Int = 101

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        val activity = activity as MainActivity?
        val view = inflater.inflate(R.layout.servicio_proveedor_registrar, container, false)

        val acti = activity as AppCompatActivity

        loc = ClsLocalizacion(acti)
        loc!!.clickMarker = true
        val mapFragment: SupportMapFragment = childFragmentManager.findFragmentById(R.id.frg) as SupportMapFragment
        mapFragment.getMapAsync(loc)
        val btnSolicitarServicio: Button = view.findViewById(R.id.btnSolicitarServicio)

        btnSolicitarServicio.setOnClickListener {
            val bs = Bundle()
            if (ClsLocalizacion.lastLatLong != null) {
                bs.putString("accion", "solicitar")
                bs.putDouble("lat", ClsLocalizacion.lastLatLong!!.latitude)
                bs.putDouble("long", ClsLocalizacion.lastLatLong!!.longitude)
            }
            val frag = ServicioProveedorReferenciaDialog()
            frag.arguments = bs
            frag.setTargetFragment(this, FRAGMENTO_AGREGAR)
            frag.show(fragmentManager!!, "dialogfrag")
        }
        return view
    }
    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        when(requestCode){
            FRAGMENTO_AGREGAR->{
                if (resultCode == 1) {
                    fragmentManager?.popBackStack()
                    AlertaMensaje.mostrarInfo(activity!!,"Petición de servicio registrada")
                }
            }
            else->{
            }
        }
    }
}